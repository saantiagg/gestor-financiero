<div>
    <x-input-label for="nombre" value="Nombre" />
    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
        :value="old('nombre', $cuenta->nombre)" maxlength="150" required autofocus />
    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full"
        :value="old('descripcion', $cuenta->descripcion)" maxlength="255" />
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="moneda" value="Moneda" />
    <select id="moneda" name="moneda" required
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach (['COP', 'USD', 'EUR'] as $moneda)
            <option value="{{ $moneda }}" @selected(old('moneda', $cuenta->moneda) === $moneda)>{{ $moneda }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('moneda')" class="mt-2" />
</div>

@if ($cuenta->exists)
    <div class="mt-4">
        <x-input-label value="Saldo actual" />
        <p class="mt-1 text-lg font-semibold text-gray-900">
            {{ number_format($cuenta->saldo, 2, ',', '.') }} {{ $cuenta->moneda }}
        </p>
        <p class="mt-1 text-sm text-gray-500">
            El saldo se actualiza automáticamente con las transacciones y no se edita aquí.
        </p>
    </div>
@else
    <div class="mt-4">
        <x-input-label for="saldo" value="Saldo inicial" />
        <x-text-input id="saldo" name="saldo" type="number" step="0.01" min="0" class="mt-1 block w-full"
            :value="old('saldo', $cuenta->saldo)" required />
        <x-input-error :messages="$errors->get('saldo')" class="mt-2" />
    </div>
@endif