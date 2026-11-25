<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaccionRequest;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Services\TransaccionService;
use Illuminate\Validation\ValidationException;

class TransaccionController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(10);

        return view('transacciones.index', compact('transacciones'));
    }

    public function create()
    {
        return view('transacciones.create', [
            'transaccion' => new Transaccion(['fecha' => now()]),
            'cuentas' => Cuenta::orderBy('nombre')->get(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function store(TransaccionRequest $request, TransaccionService $servicio)
    {
        $servicio->crear($request->validated(), auth()->user()->name);

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción registrada correctamente.');
    }

    public function edit(Transaccion $transaccion)
    {
        return view('transacciones.edit', [
            'transaccion' => $transaccion,
            'cuentas' => Cuenta::orderBy('nombre')->get(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function update(TransaccionRequest $request, Transaccion $transaccion, TransaccionService $servicio)
    {
        $servicio->actualizar($transaccion, $request->validated());

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción actualizada correctamente.');
    }

    public function destroy(Transaccion $transaccion, TransaccionService $servicio)
    {
        try {
            $servicio->eliminar($transaccion);
        } catch (ValidationException $e) {
            return redirect()
                ->route('transacciones.index')
                ->with('error', collect($e->errors())->flatten()->first());
        }

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción eliminada correctamente.');
    }
}