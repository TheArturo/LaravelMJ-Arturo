<x-layouts.app :title="'Editar Proveedor'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:600px; background:#292929; border-radius:12px; padding:32px;">
            <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}"
                style="display:flex; flex-direction:column; gap:20px;">
                @csrf
                @method('PUT')
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Editar
                    Proveedor</h2>
                <input type="text" name="ruc" id="ruc" placeholder="RUC" value="{{ $proveedor->ruc }}"
                    maxlength="11" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="nombres" id="nombres" placeholder="Nombres"
                    value="{{ $proveedor->nombres }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono"
                    value="{{ $proveedor->telefono }}" maxlength="20" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección"
                    value="{{ $proveedor->direccion }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón Social"
                    value="{{ $proveedor->razon_social }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Actualizar</button>
                    <a href="{{ route('proveedores.index') }}"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; text-align:center; text-decoration:none; cursor:pointer;">Volver</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
