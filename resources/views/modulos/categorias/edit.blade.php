@vite('resources/css/categorias.css')
<x-layouts.app :title="'Editar Categoría'">
    <div class="categorias-bg">
        <div class="categorias-container">
            <form method="POST" action="{{ route('categorias.update', $categoria->id) }}" class="categorias-form">
                @csrf
                @method('PUT')
                <h2 class="categorias-title">Editar Categoría</h2>
                <input type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }}"
                    placeholder="Nombre de la categoría" class="categorias-input">
                <div class="categorias-actions">
                    <button type="submit" class="categorias-btn">Guardar</button>
                    <a href="{{ route('categorias.index') }}"
                        class="categorias-btn categorias-btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/categorias.js') }}"></script>
