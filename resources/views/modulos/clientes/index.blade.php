@vite('resources/css/clientes.css')
<x-layouts.app :title="'Clientes'">
    <div class="cliente-index-bg">
        <div class="cliente-index-container">
            {{-- ================= FORMULARIO DE CLIENTE ================= --}}
            <!-- Formulario -->
            <div class="cliente-index-form-col">
                <form id="formCliente" method="POST"
                    action="{{ isset($editCliente) ? route('clientes.update', $editCliente->id) : route('clientes.store') }}"
                    class="cliente-index-form">
                    @csrf
                    <input type="hidden" name="_method" id="inputMethod" value="POST"> {{-- método --}}
                    <h2 class="cliente-index-title">Nuevo Cliente</h2>
                    <input type="text" name="dni" id="dni" placeholder="DNI"
                        value="{{ old('dni', $editCliente->dni ?? '') }}" maxlength="15" inputmode="numeric"
                        pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                        class="cliente-index-input">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre"
                        value="{{ old('nombre', $editCliente->nombre ?? '') }}" class="cliente-index-input">
                    <input type="text" name="apellido" id="apellido" placeholder="Apellido"
                        value="{{ old('apellido', $editCliente->apellido ?? '') }}" class="cliente-index-input">
                    <input type="text" name="direccion" id="direccion" placeholder="Dirección"
                        value="{{ old('direccion', $editCliente->direccion ?? '') }}" class="cliente-index-input">
                    <input type="text" name="celular" id="celular" placeholder="Celular"
                        value="{{ old('celular', $editCliente->celular ?? '') }}" maxlength="15" inputmode="numeric"
                        pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                        class="cliente-index-input">
                    @if ($errors->has('celular'))
                        <div class="cliente-index-error">{{ $errors->first('celular') }}</div>
                    @endif
                    <div class="cliente-index-actions">
                        <button type="submit" id="btnGuardar" class="cliente-index-btn">Guardar</button>
                        <button type="button" id="btnLimpiar" class="cliente-index-cancel">Limpiar</button>
                    </div>
                </form>
                {{-- =============== FIN FORMULARIO DE CLIENTE =============== --}}
            </div>
            <div class="cliente-index-list-col">
                {{-- ================== TABLA DE CLIENTES ================== --}}
                <!-- Tabla -->
                <div class="cliente-index-list">
                    {{-- Formulario de búsqueda --}}
                    <form method="GET" action="{{ route('clientes.index') }}" class="cliente-index-search">
                        <input type="text" name="term" value="{{ request('term') }}"
                            placeholder="Buscar por DNI..." class="cliente-index-input">
                        <button type="submit" class="cliente-index-btn cliente-index-btn-search">Buscar</button>
                        <a href="{{ route('clientes.index') }}"
                            class="cliente-index-cancel cliente-index-btn-list">Listar</a>
                    </form>
                    <div class="cliente-index-table-wrap">
                        <table class="cliente-index-table">
                            <thead>
                                <tr class="cliente-index-table-header">
                                    <th class="cliente-index-th">ID</th>
                                    <th class="cliente-index-th">DNI</th>
                                    <th class="cliente-index-th">Nombre</th>
                                    <th class="cliente-index-th">Apellido</th>
                                    <th class="cliente-index-th">Dirección</th>
                                    <th class="cliente-index-th">Celular</th>
                                    <th class="cliente-index-th"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientes as $cliente)
                                    <tr class="cliente-index-tr">
                                        <td class="cliente-index-td">{{ $cliente->id }}</td>
                                        <td class="cliente-index-td">{{ $cliente->dni }}</td>
                                        <td class="cliente-index-td">{{ $cliente->nombre }}</td>
                                        <td class="cliente-index-td">{{ $cliente->apellido }}</td>
                                        <td class="cliente-index-td">{{ $cliente->direccion }}</td>
                                        <td class="cliente-index-td">{{ $cliente->celular }}</td>
                                        <td class="cliente-index-td">
                                            <div class="cliente-index-actions-table">
                                                <a href="{{ route('clientes.edit', $cliente->id) }}"
                                                    class="cliente-index-btn cliente-index-btn-edit">Editar</a>
                                                <form method="POST"
                                                    action="{{ route('clientes.destroy', $cliente->id) }}"
                                                    class="cliente-index-form-delete"
                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="cliente-index-btn cliente-index-btn-delete">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="cliente-index-empty">No hay clientes registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="cliente-index-pagination">
                        {{ $clientes->links() }}
                    </div>
                </div>
                {{-- =============== FIN TABLA DE CLIENTES =============== --}}
            </div>
        </div>
    </div>

</x-layouts.app>

{{-- ================== SCRIPTS JS ================== --}}
<script src="{{ asset('resources/js/clientes.js') }}"></script> {{-- js clientes --}}
