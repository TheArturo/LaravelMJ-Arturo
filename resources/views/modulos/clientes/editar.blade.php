<x-layouts.app :title="'Editar Cliente'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:500px; background:#292929; border-radius:12px; padding:32px;">
            <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Editar
                Cliente</h2>
            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}"
                style="display:flex; flex-direction:column; gap:20px;">
                @csrf
                @method('PUT')
                <input type="text" name="dni" placeholder="DNI" value="{{ old('dni', $cliente->dni) }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="nombre" placeholder="Nombre" value="{{ old('nombre', $cliente->nombre) }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="apellido" placeholder="Apellido"
                    value="{{ old('apellido', $cliente->apellido) }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="direccion" placeholder="Dirección"
                    value="{{ old('direccion', $cliente->direccion) }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="celular" placeholder="Celular"
                    value="{{ old('celular', $cliente->celular) }}"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Actualizar</button>
                    <a href="{{ route('clientes.index') }}"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; text-align:center; text-decoration:none; cursor:pointer;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
