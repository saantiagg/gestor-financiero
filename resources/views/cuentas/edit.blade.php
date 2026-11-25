<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar cuenta
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('cuentas.update', $cuenta) }}">
                    @csrf
                    @method('PUT')

                    @include('cuentas._form')

                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>Actualizar</x-primary-button>
                        <a href="{{ route('cuentas.index') }}" class="text-sm text-gray-600 underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>