<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transacciones
            </h2>
            <a href="{{ route('transacciones.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Crear
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuenta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registrado por</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($transacciones as $transaccion)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                    {{ $transaccion->fecha->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $transaccion->cuenta->nombre }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $transaccion->categoria->nombre }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaccion->tipo === 'ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($transaccion->tipo) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-semibold whitespace-nowrap {{ $transaccion->tipo === 'ingreso' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $transaccion->tipo === 'ingreso' ? '+' : '-' }}{{ number_format($transaccion->monto, 2, ',', '.') }}
                                    {{ $transaccion->cuenta->moneda }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $transaccion->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $transaccion->creado_por }}</td>
                                <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                                    <a href="{{ route('transacciones.edit', $transaccion) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>

                                    <form action="{{ route('transacciones.destroy', $transaccion) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Seguro que quieres eliminar esta transacción?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    No hay transacciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transacciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>