<x-layouts.app :title="'Clientes'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:1100px; display:flex; gap:48px;">
            {{-- ================= FORMULARIO DE CLIENTE ================= --}}
            <!-- Formulario -->
            <form id="formCliente" method="POST"
                action="{{ isset($editCliente) ? route('clientes.update', $editCliente->id) : route('clientes.store') }}"
                style="flex:1; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST"> {{-- método --}}
                <input type="hidden" name="cliente_id" id="cliente_id" value=""> {{-- id --}}
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Nuevo
                    Cliente</h2>
                <input type="text" name="dni" id="dni" placeholder="DNI" value="" inputmode="numeric"
                    pattern="[0-9]*" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                {{-- dni --}}


                <input type="text" name="nombre" id="nombre" placeholder="Nombre" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                {{-- nombre --}}


                <input type="text" name="apellido" id="apellido" placeholder="Apellido" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                {{-- apellido --}}


                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                {{-- dirección --}}


                <input type="text" name="celular" id="celular" placeholder="Celular" value=""
                    inputmode="numeric" pattern="[0-9]*" maxlength="15"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                {{-- celular --}}


                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit" id="btnGuardar"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Guardar</button>
                    {{-- guardar --}}


                    <button type="button" id="btnLimpiar"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Limpiar</button>
                    {{-- limpiar --}}


                </div>
            </form>
            {{-- =============== FIN FORMULARIO DE CLIENTE =============== --}}

            {{-- ================== TABLA DE CLIENTES ================== --}}
            <!-- Tabla -->
            <div
                style="flex:2; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                {{-- Formulario de búsqueda --}}
                <form method="GET" action="{{ route('clientes.index') }}" style="display:flex; gap:16px; margin-bottom:16px;">
                    <input type="text" name="term" value="{{ request('term') }}" placeholder="Buscar por DNI..."
                        style="flex:1; padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <button type="submit"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; cursor:pointer;">
                        Buscar
                    </button>
                    <a href="{{ route('clientes.index') }}"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; text-align:center; text-decoration:none; cursor:pointer;">
                        Listar
                    </a>
                </form>
                <div style="overflow-x:auto;">
                    <table
                        style="width:100%; border-collapse:collapse; background:#222; color:#fff; border-radius:8px; overflow:hidden;">
                        <thead>
                            <tr style="background:#2563eb; color:#fff;">
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">ID</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">DNI</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">Nombre</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">Apellido</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">Dirección</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">Celular</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                                <tr style="border-bottom:1px solid #333; background:#222;">
                                    <td style="padding:10px 8px;">{{ $cliente->id }}</td> {{-- id --}}
                                    <td style="padding:10px 8px;">{{ $cliente->dni }}</td> {{-- dni --}}
                                    <td style="padding:10px 8px;">{{ $cliente->nombre }}</td> {{-- nombre --}}
                                    <td style="padding:10px 8px;">{{ $cliente->apellido }}</td> {{-- apellido --}}
                                    <td style="padding:10px 8px;">{{ $cliente->direccion }}</td> {{-- dirección --}}
                                    <td style="padding:10px 8px;">{{ $cliente->celular }}</td> {{-- celular --}}
                                    <td style="padding:10px 8px;">
                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('clientes.edit', $cliente->id) }}"
                                                style="background:#2563eb; color:#fff; border-radius:6px; padding:6px 16px; text-decoration:none; font-size:0.95rem;">Editar</a>
                                            {{-- editar --}}
                                            <form method="POST" action="{{ route('clientes.destroy', $cliente->id) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:#dc2626; color:#fff; border:none; border-radius:6px; padding:6px 16px; font-size:0.95rem; cursor:pointer;">Eliminar</button>
                                                {{-- eliminar --}}
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align:center; padding:16px; color:#aaa;">No hay
                                        clientes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Paginación --}}
                <div style="margin-top:24px; text-align:center;">
                    {{ $clientes->links() }}
                </div>
            </div>
            {{-- =============== FIN TABLA DE CLIENTES =============== --}}
        </div>
    </div>
</x-layouts.app>

{{-- ================== SCRIPTS JS ================== --}}
<script src="{{ asset('resources/js/clientes.js') }}"></script> {{-- js clientes --}}
