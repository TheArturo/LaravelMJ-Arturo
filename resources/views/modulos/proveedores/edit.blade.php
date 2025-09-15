@vite('resources/css/proveedores.css')
<x-layouts.app :title="'Editar Proveedor'">
    <div class="proveedor-index-bg">
        <div class="proveedor-index-container">
            <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}" class="proveedor-index-form">
                @csrf
                @method('PUT')
                <h2 class="proveedor-index-title">Editar Proveedor</h2>
                <input type="text" name="ruc" id="ruc" placeholder="RUC" value="{{ $proveedor->ruc }}" maxlength="11" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="proveedor-index-input">
                <input type="text" name="nombres" id="nombres" placeholder="Nombres" value="{{ $proveedor->nombres }}" class="proveedor-index-input">
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono" value="{{ $proveedor->telefono }}" maxlength="20" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="proveedor-index-input">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value="{{ $proveedor->direccion }}" class="proveedor-index-input">
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón Social" value="{{ $proveedor->razon_social }}" class="proveedor-index-input">
                <div class="proveedor-index-actions">
                    <button type="submit" class="proveedor-index-btn">Actualizar</button>
                    <a href="{{ route('proveedores.index') }}" class="proveedor-index-cancel">Volver</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
