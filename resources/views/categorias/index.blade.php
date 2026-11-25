<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categorías
            </h2>
            <a href="{{ route('categorias.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Crear
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-messages />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $categoria->nombre }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $categoria->tipo === 'ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($categoria->tipo) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $categoria->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-right whitespace-nowrap">
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>

                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Seguro que quieres eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>