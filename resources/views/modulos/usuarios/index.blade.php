@vite('resources/css/productos.css')
<x-layouts.app :title="__('Usuarios')">
    <div class="producto-index-bg">
        <div class="producto-index-container">
            <form id="formUsuario" method="POST"
                action="{{ isset($editUsuario) ? route('usuarios.update', $editUsuario->id) : route('usuarios.store') }}"
                class="producto-index-form">
                @csrf
                @if(isset($editUsuario))
                    @method('PUT')
                @endif
                <input type="hidden" name="usuario_id" id="usuario_id" value="">
                <h2 class="producto-index-title">{{ isset($editUsuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
                <input type="text" name="name" id="name" placeholder="Nombre completo" value="{{ old('name', isset($editUsuario) ? $editUsuario->name : '') }}"
                    class="producto-index-input">
                <input type="email" name="email" id="email" placeholder="Correo electrónico" value="{{ old('email', isset($editUsuario) ? $editUsuario->email : '') }}"
                    class="producto-index-input">
                <input type="password" name="password" id="password" placeholder="Contraseña (dejar en blanco para no cambiar)" value=""
                    class="producto-index-input">
                <select name="role_id" id="role_id" class="producto-index-select">
                    <option value="">Seleccionar rol</option>
                    @foreach($roles ?? [] as $role)
                        <option value="{{ $role->id }}" {{ (isset($editUsuario) && $editUsuario->role_id == $role->id) || old('role_id') == $role->id ? 'selected' : '' }}>{{ ucfirst($role->nombre) }}</option>
                    @endforeach
                </select>
                <div class="producto-index-actions">
                    <button type="submit" id="btnGuardar" class="producto-index-btn">Guardar</button>
                    <a href="{{ route('usuarios.index') }}" class="producto-index-cancel">Cancelar</a>
                </div>
            </form>
            <div class="producto-index-list">
                <form method="GET" action="{{ route('usuarios.index') }}" class="producto-index-search">
                    <input type="text" name="term" value="{{ request('term') }}"
                        placeholder="Buscar por nombre o correo..." class="producto-index-input">
                    <button type="submit" class="producto-index-btn producto-index-btn-search">Buscar</button>
                    <a href="{{ route('usuarios.index') }}" class="producto-index-cancel producto-index-btn-list">Listar</a>
                </form>

                <div class="producto-index-table-wrap">
                    <table class="producto-index-table">
                        <thead>
                            <tr class="producto-index-table-header">
                                <th class="producto-index-th">NOMBRE</th>
                                <th class="producto-index-th">EMAIL</th>
                                <th class="producto-index-th">ROL</th>
                                <th class="producto-index-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="producto-index-tr">
                                    <td class="producto-index-td">{{ $user->name }}</td>
                                    <td class="producto-index-td">{{ $user->email }}</td>
                                    <td class="producto-index-td">{{ optional($user->role)->nombre ?? 'Sin rol' }}</td>
                                    <td class="producto-index-td">
                                        <div class="producto-index-actions-table">
                                            <a href="{{ route('usuarios.edit', $user->id) }}" class="producto-index-btn producto-index-btn-edit">Editar</a>
                                            <form method="POST" action="{{ route('usuarios.destroy', $user->id) }}" class="producto-index-form-delete"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="producto-index-btn producto-index-btn-delete">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="producto-index-empty">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="producto-index-pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/productos.js') }}"></script>
