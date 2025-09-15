@vite('resources/css/clientes.css')
<x-layouts.app :title="'Editar Cliente'">
    <div class="cliente-index-bg">
        <div class="cliente-index-container">
            <div class="cliente-index-form-col">
                <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" class="cliente-index-form">
                    @csrf
                    @method('PUT')
                    <h2 class="cliente-index-title">Editar Cliente</h2>
                    <input type="text" name="dni" id="dni" placeholder="DNI" value="{{ old('dni', $cliente->dni) }}" maxlength="15" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="cliente-index-input">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $cliente->nombre) }}" class="cliente-index-input">
                    <input type="text" name="apellido" id="apellido" placeholder="Apellido" value="{{ old('apellido', $cliente->apellido) }}" class="cliente-index-input">
                    <input type="text" name="direccion" id="direccion" placeholder="Dirección" value="{{ old('direccion', $cliente->direccion) }}" class="cliente-index-input">
                    <input type="text" name="celular" id="celular" placeholder="Celular" value="{{ old('celular', $cliente->celular) }}" maxlength="15" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="cliente-index-input">
                    @if ($errors->has('celular'))
                        <div class="cliente-index-error">{{ $errors->first('celular') }}</div>
                    @endif
                    <div class="cliente-index-actions">
                        <button type="submit" class="cliente-index-btn">Actualizar</button>
                        <a href="{{ route('clientes.index') }}" class="cliente-index-cancel">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
