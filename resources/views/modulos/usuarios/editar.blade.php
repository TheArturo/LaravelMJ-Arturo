@vite('resources/css/productos.css')
<x-layouts.app :title="__('Editar usuario')">
    <div class="producto-index-bg">
        <div class="producto-index-container">
            <form id="formUsuario" method="POST" action="{{ route('usuarios.update', $user->id) }}" class="producto-index-form">
                @csrf
                @method('PUT')
                <h2 class="producto-index-title">Editar Usuario</h2>
                <input type="text" name="name" id="name" placeholder="Nombre completo" value="{{ old('name', $user->name) }}"
                    class="producto-index-input">
                <input type="email" name="email" id="email" placeholder="Correo electrónico" value="{{ old('email', $user->email) }}"
                    class="producto-index-input">
                <input type="password" name="password" id="password" placeholder="Contraseña (dejar en blanco para no cambiar)" value=""
                    class="producto-index-input">
                <select name="role_id" id="role_id" class="producto-index-select">
                    <option value="">Seleccionar rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>{{ ucfirst($role->nombre) }}</option>
                    @endforeach
                </select>
                <div class="producto-index-actions">
                    <button type="submit" id="btnGuardar" class="producto-index-btn">Guardar</button>
                    <a href="{{ route('usuarios.index') }}" class="producto-index-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
