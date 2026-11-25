<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaccionRequest;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;

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

    public function store(TransaccionRequest $request)
    {
        $datos = $request->validated();
        $datos['creado_por'] = auth()->user()->name;

        Transaccion::create($datos);

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

    public function update(TransaccionRequest $request, Transaccion $transaccion)
    {
        $transaccion->update($request->validated());

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción actualizada correctamente.');
    }

    public function destroy(Transaccion $transaccion)
    {
        $transaccion->delete();

        return redirect()
            ->route('transacciones.index')
            ->with('success', 'Transacción eliminada correctamente.');
    }
}