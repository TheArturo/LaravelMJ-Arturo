<x-layouts.app :title="'Editar Categoría'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:600px; background:#292929; border-radius:12px; padding:32px;">
            <form method="POST" action="{{ route('categorias.update', $categoria->id) }}" style="display:flex; flex-direction:column; gap:20px;">
                @csrf
                @method('PUT')
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Editar Categoría</h2>
                <input type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}" placeholder="Nombre de la categoría"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit" style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Guardar</button>
                    <a href="{{ route('categorias.index') }}" style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; text-align:center; text-decoration:none; cursor:pointer;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/categorias.js') }}"></script>
