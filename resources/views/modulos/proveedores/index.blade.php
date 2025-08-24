<x-layouts.app :title="'Proveedores'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:1100px; display:flex; gap:48px;">
            {{-- ================= FORMULARIO DE PROVEEDOR ================= --}}
            <form id="formProveedor" method="POST"
                action="{{ isset($editProveedor) ? route('proveedores.update', $editProveedor->id) : route('proveedores.store') }}"
                style="flex:1; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST"> {{-- método --}}
                <input type="hidden" name="proveedor_id" id="proveedor_id" value=""> {{-- id --}}
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Nuevo
                    Proveedor
                </h2>
                <input type="text" name="ruc" id="ruc" placeholder="RUC" value="" maxlength="11"
                    inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="nombres" id="nombres" placeholder="Nombres" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono" value=""
                    maxlength="20" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón Social" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit" id="btnGuardar"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Guardar
                    </button>
                    <button type="button" id="btnLimpiar"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Limpiar
                    </button>
                </div>
            </form>
            {{-- =============== FIN FORMULARIO DE PROVEEDOR =============== --}}

            {{-- ================== TABLA DE PROVEEDORES ================== --}}
            <div
                style="flex:2; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                <form method="GET" action="{{ route('proveedores.index') }}"
                    style="display:flex; gap:16px; margin-bottom:16px;">
                    <input type="text" name="term" value="{{ request('term') }}" placeholder="Buscar..."
                        style="flex:1; padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <button type="submit"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; cursor:pointer;">
                        Buscar
                    </button>
                    <a href="{{ route('proveedores.index') }}"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; text-align:center; text-decoration:none; cursor:pointer;">
                        Listar
                    </a>
                </form>
                <div style="overflow-x:auto;">
                    <table
                        style="width:100%; border-collapse:collapse; background:#222; color:#fff; border-radius:8px; overflow:hidden;">
                        <thead>
                            <tr style="background:#2563eb; color:#fff;">
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    ID</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    RUC</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    Nombres</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    Teléfono</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    Dirección</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                    Razón Social</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600; white-space:nowrap;">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proveedores as $proveedor)
                                <tr style="border-bottom:1px solid #333; background:#222;">
                                    <td style="padding:10px 8px;">{{ $proveedor->id }}</td>
                                    <td style="padding:10px 8px;">{{ $proveedor->ruc }}</td>
                                    <td style="padding:10px 8px;">{{ $proveedor->nombres }}</td>
                                    <td style="padding:10px 8px;">{{ $proveedor->telefono }}</td>
                                    <td style="padding:10px 8px;">{{ $proveedor->direccion }}</td>
                                    <td style="padding:10px 8px;">{{ $proveedor->razon_social }}</td>
                                    <td style="padding:10px 8px;">
                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('proveedores.edit', $proveedor->id) }}"
                                                style="background:#2563eb; color:#fff; border-radius:6px; padding:6px 16px; text-decoration:none; font-size:0.95rem;">
                                                Editar
                                            </a>
                                            <form method="POST"
                                                action="{{ route('proveedores.destroy', $proveedor->id) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este proveedor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:#dc2626; color:#fff; border:none; border-radius:6px; padding:6px 16px; font-size:0.95rem; cursor:pointer;">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        style="text-align:center; padding:16px; color:#aaa; white-space:nowrap;">
                                        No hay proveedores registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- =============== FIN TABLA DE PROVEEDORES =============== --}}
        </div>
    </div>
</x-layouts.app>

{{-- ================== SCRIPTS JS ================== --}}
<script src="{{ asset('resources/js/proveedores.js') }}"></script> {{-- js proveedores --}}
