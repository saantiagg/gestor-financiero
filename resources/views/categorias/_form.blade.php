<div>
    <x-input-label for="nombre" value="Nombre" />
    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
        :value="old('nombre', $categoria->nombre)" maxlength="150" required autofocus />
    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="tipo" value="Tipo" />
    <select id="tipo" name="tipo" required
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Seleccione...</option>
        <option value="ingreso" @selected(old('tipo', $categoria->tipo) === 'ingreso')>Ingreso</option>
        <option value="gasto" @selected(old('tipo', $categoria->tipo) === 'gasto')>Gasto</option>
    </select>
    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full"
        :value="old('descripcion', $categoria->descripcion)" maxlength="255" />
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>