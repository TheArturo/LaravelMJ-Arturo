@vite('resources/css/proveedores.css')
<x-layouts.app :title="'Proveedores'">
    <div class="proveedor-index-bg">
        <div class="proveedor-index-container">
            {{-- ================= FORMULARIO DE PROVEEDOR ================= --}}
            <form id="formProveedor" method="POST"
                action="{{ isset($editProveedor) ? route('proveedores.update', $editProveedor->id) : route('proveedores.store') }}"
                class="proveedor-index-form">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST"> {{-- método --}}
                <input type="hidden" name="proveedor_id" id="proveedor_id" value=""> {{-- id --}}
                <h2 class="proveedor-index-title">Nuevo Proveedor</h2>
                <input type="text" name="ruc" id="ruc" placeholder="RUC" value="" maxlength="11"
                    inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    class="proveedor-index-input">
                <input type="text" name="nombres" id="nombres" placeholder="Nombres" value=""
                    class="proveedor-index-input">
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono" value=""
                    maxlength="20" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="proveedor-index-input">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value=""
                    class="proveedor-index-input">
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón Social" value=""
                    class="proveedor-index-input">
                <div class="proveedor-index-actions">
                    <button type="submit" id="btnGuardar" class="proveedor-index-btn">Guardar</button>
                    <button type="button" id="btnLimpiar" class="proveedor-index-cancel">Limpiar</button>
                </div>
            </form>
            {{-- =============== FIN FORMULARIO DE PROVEEDOR =============== --}}

            {{-- ================== TABLA DE PROVEEDORES ================== --}}
            <div class="proveedor-index-list">
                <form method="GET" action="{{ route('proveedores.index') }}" class="proveedor-index-search">
                    <input type="text" name="term" value="{{ request('term') }}" placeholder="Buscar..."
                        class="proveedor-index-input">
                    <button type="submit" class="proveedor-index-btn proveedor-index-btn-search">Buscar</button>
                    <a href="{{ route('proveedores.index') }}"
                        class="proveedor-index-cancel proveedor-index-btn-list">Listar</a>
                </form>
                <div class="proveedor-index-table-wrap">
                    <table class="proveedor-index-table">
                        <thead>
                            <tr class="proveedor-index-table-header">
                                <th class="proveedor-index-th">ID</th>
                                <th class="proveedor-index-th">RUC</th>
                                <th class="proveedor-index-th">Nombres</th>
                                <th class="proveedor-index-th">Teléfono</th>
                                <th class="proveedor-index-th">Dirección</th>
                                <th class="proveedor-index-th">Razón Social</th>
                                <th class="proveedor-index-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proveedores as $proveedor)
                                <tr class="proveedor-index-tr">
                                    <td class="proveedor-index-td">{{ $proveedor->id }}</td>
                                    <td class="proveedor-index-td">{{ $proveedor->ruc }}</td>
                                    <td class="proveedor-index-td">{{ $proveedor->nombres }}</td>
                                    <td class="proveedor-index-td">{{ $proveedor->telefono }}</td>
                                    <td class="proveedor-index-td">{{ $proveedor->direccion }}</td>
                                    <td class="proveedor-index-td">{{ $proveedor->razon_social }}</td>
                                    <td class="proveedor-index-td">
                                        <div class="proveedor-index-actions-table">
                                            <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                                                class="proveedor-index-btn proveedor-index-btn-edit">Editar</a>
                                            <form method="POST"
                                                action="{{ route('proveedores.destroy', $proveedor->id) }}"
                                                class="proveedor-index-form-delete"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este proveedor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="proveedor-index-btn proveedor-index-btn-delete">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="proveedor-index-empty">No hay proveedores registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="proveedor-index-pagination">
                    {{ $proveedores->links() }}
                </div>
            </div>
            {{-- =============== FIN TABLA DE PROVEEDORES =============== --}}
        </div>
    </div>
</x-layouts.app>

{{-- ================== SCRIPTS JS ================== --}}
<script src="{{ asset('resources/js/proveedores.js') }}"></script> {{-- js proveedores --}}

@if (session('error'))
    <div class="proveedor-index-error">{{ session('error') }}</div>
@endif
