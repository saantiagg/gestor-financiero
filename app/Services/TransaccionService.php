<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaccionService
{
    /**
     * Registra una transacción y actualiza el saldo de la cuenta.
     */
    public function crear(array $datos, string $creadoPor): Transaccion
    {
        return DB::transaction(function () use ($datos, $creadoPor) {
            $cuentaId = (int) $datos['cuenta_id'];

            $this->bloquearCuentas([$cuentaId]);

            $this->aplicar($cuentaId, $datos['tipo'], $datos['monto']);

            $transaccion = Transaccion::create($datos + ['creado_por' => $creadoPor]);

            $this->verificarSaldos(
                [$cuentaId],
                'El movimiento deja la cuenta «%s» con saldo negativo. No se permite gastar más del saldo disponible.'
            );

            return $transaccion;
        });
    }

    /**
     * Edita una transacción: revierte el efecto anterior y aplica el nuevo.
     */
    public function actualizar(Transaccion $transaccion, array $datos): Transaccion
    {
        return DB::transaction(function () use ($transaccion, $datos) {
            $cuentaAnteriorId = (int) $transaccion->cuenta_id;
            $cuentaNuevaId = (int) $datos['cuenta_id'];
            $ids = array_values(array_unique([$cuentaAnteriorId, $cuentaNuevaId]));

            $cuentas = $this->bloquearCuentas($ids);

            if ($cuentas[$cuentaAnteriorId]->moneda !== $cuentas[$cuentaNuevaId]->moneda) {
                throw ValidationException::withMessages([
                    'cuenta_id' => 'No puedes mover la transacción a una cuenta con otra moneda.',
                ]);
            }

            // 1. Revertir el efecto anterior (en la cuenta anterior).
            $this->aplicar($cuentaAnteriorId, $transaccion->tipo, $transaccion->monto, revertir: true);

            // 2. Aplicar el efecto nuevo (en la cuenta nueva).
            $this->aplicar($cuentaNuevaId, $datos['tipo'], $datos['monto']);

            $transaccion->update($datos);

            $this->verificarSaldos(
                $ids,
                'El cambio deja la cuenta «%s» con saldo negativo. No se permite gastar más del saldo disponible.'
            );

            return $transaccion;
        });
    }

    /**
     * Elimina una transacción y revierte su efecto en el saldo.
     */
    public function eliminar(Transaccion $transaccion): void
    {
        DB::transaction(function () use ($transaccion) {
            $cuentaId = (int) $transaccion->cuenta_id;

            $this->bloquearCuentas([$cuentaId]);

            $this->aplicar($cuentaId, $transaccion->tipo, $transaccion->monto, revertir: true);

            $transaccion->delete();

            $this->verificarSaldos(
                [$cuentaId],
                'No se puede eliminar: la cuenta «%s» quedaría con saldo negativo.'
            );
        });
    }

    /**
     * Suma o resta el monto al saldo directamente en la base de datos.
     * Ingreso suma, gasto resta. Con $revertir se hace lo contrario.
     */
    private function aplicar(int $cuentaId, string $tipo, string $monto, bool $revertir = false): void
    {
        $aumenta = ($tipo === 'ingreso') !== $revertir;

        $consulta = Cuenta::where('id', $cuentaId);

        if ($aumenta) {
            $consulta->increment('saldo', $monto);
        } else {
            $consulta->decrement('saldo', $monto);
        }
    }

    /**
     * Bloquea las cuentas mientras dura la operación (evita gastar el mismo saldo dos veces).
     * Se ordenan por id para evitar bloqueos cruzados entre operaciones.
     */
    private function bloquearCuentas(array $ids)
    {
        return Cuenta::whereIn('id', $ids)
            ->orderBy('id')
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    /**
     * Si alguna cuenta afectada quedó con saldo negativo, lanza el error.
     * Al lanzarse dentro de DB::transaction, todos los cambios se deshacen.
     */
    private function verificarSaldos(array $ids, string $mensaje): void
    {
        $negativa = Cuenta::whereIn('id', $ids)->where('saldo', '<', 0)->first();

        if ($negativa) {
            throw ValidationException::withMessages([
                'monto' => sprintf($mensaje, $negativa->nombre),
            ]);
        }
    }
}