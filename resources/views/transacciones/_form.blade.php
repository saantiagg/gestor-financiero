<div x-data="{ tipo: @js(old('tipo', $transaccion->tipo)) }">

    <div>
        <x-input-label for="cuenta_id" value="Cuenta" />
        <select id="cuenta_id" name="cuenta_id" required
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">Seleccione...</option>
            @foreach ($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}"
                    @selected((string) old('cuenta_id', $transaccion->cuenta_id) === (string) $cuenta->id)>
                    {{ $cuenta->nombre }} ({{ $cuenta->moneda }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('cuenta_id')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="tipo" value="Tipo" />
        <select id="tipo" name="tipo" required x-model="tipo" @change="$refs.categoria.value = ''"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">Seleccione...</option>
            <option value="ingreso">Ingreso</option>
            <option value="gasto">Gasto</option>
        </select>
        <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="categoria_id" value="Categoría" />
        <select id="categoria_id" name="categoria_id" required x-ref="categoria"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">Seleccione...</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    x-bind:hidden="tipo !== '{{ $categoria->tipo }}'"
                    x-bind:disabled="tipo !== '{{ $categoria->tipo }}'"
                    @selected((string) old('categoria_id', $transaccion->categoria_id) === (string) $categoria->id)>
                    {{ $categoria->nombre }} ({{ ucfirst($categoria->tipo) }})
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="monto" value="Monto" />
        <x-text-input id="monto" name="monto" type="number" step="0.01" min="0.01" class="mt-1 block w-full"
            :value="old('monto', $transaccion->monto)" required />
        <x-input-error :messages="$errors->get('monto')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="fecha" value="Fecha" />
        <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full"
            :value="old('fecha', $transaccion->fecha?->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-input-label for="descripcion" value="Descripción (opcional)" />
        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full"
            :value="old('descripcion', $transaccion->descripcion)" maxlength="255" />
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>
</div>