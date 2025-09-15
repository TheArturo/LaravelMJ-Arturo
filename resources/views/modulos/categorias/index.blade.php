@vite('resources/css/categorias.css')
<x-layouts.app :title="'Categorías'">
    <div class="categorias-bg">
        <div class="categorias-container">
            <form id="formCategoria" method="POST"
                action="{{ isset($editCategoria) ? route('categorias.update', $editCategoria->id) : route('categorias.store') }}"
                class="categorias-form">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST">
                <input type="hidden" name="categoria_id" id="categoria_id" value="">
                <h2 class="categorias-title">Nueva Categoría</h2>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de la categoría" value=""
                    class="categorias-input">
                <div class="categorias-actions">
                    <button type="submit" id="btnGuardar" class="categorias-btn">Guardar</button>
                    <button type="button" id="btnLimpiar"
                        class="categorias-btn categorias-btn-secondary">Limpiar</button>
                </div>
            </form>
            <div class="categorias-list-container">
                <form method="GET" action="{{ route('categorias.index') }}" class="categorias-search-form">
                    <input type="text" name="term" value="{{ request('term') }}"
                        placeholder="Buscar por nombre..." class="categorias-search-input">
                    <button type="submit" class="categorias-btn">Buscar</button>
                    <a href="{{ route('categorias.index') }}" class="categorias-btn categorias-btn-secondary">Listar</a>
                </form>
                <div class="categorias-table-wrapper">
                    <table class="categorias-table">
                        <thead>
                            <tr class="categorias-table-header">
                                <th class="categorias-table-th">ID</th>
                                <th class="categorias-table-th">Nombre</th>
                                <th class="categorias-table-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorias as $categoria)
                                <tr class="categorias-table-row">
                                    <td class="categorias-table-td">{{ $categoria->id }}</td>
                                    <td class="categorias-table-td">{{ $categoria->nombre }}</td>
                                    <td class="categorias-table-td">
                                        <div class="categorias-table-actions">
                                            <a href="{{ route('categorias.edit', $categoria->id) }}"
                                                class="categorias-btn">Editar</a>
                                            <form method="POST"
                                                action="{{ route('categorias.destroy', $categoria->id) }}"
                                                class="categorias-delete-form"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="categorias-btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="categorias-table-empty">
                                    <td colspan="3">No hay categorías registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="categorias-pagination">
                    {{ $categorias->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
@if (session('error'))
    <div class="categorias-error">
        {{ session('error') }}
    </div>
@endif
<script src="{{ asset('resources/js/categorias.js') }}"></script>
