@vite('resources/css/clientes.css')
<x-layouts.app :title="'Editar Cliente'">
    <div class="cliente-index-bg">
        <div class="cliente-index-container">
            <div class="cliente-index-form-col">
                <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" class="cliente-index-form">
                    @csrf
                    @method('PUT')
                    <h2 class="cliente-index-title">Editar Cliente</h2>
                    <div class="form-group">
                        <div class="flex">
                            <select name="tipo_persona" id="tipo_persona" class="cliente-index-input flex-grow mr-2">
                                <option value="" disabled>Tipo de persona</option>
                                <option value="NATURAL" {{ old('tipo_persona', $cliente->tipo_persona) == 'NATURAL' ? 'selected' : '' }}>NATURAL</option>
                                <option value="JURÍDICA" {{ old('tipo_persona', $cliente->tipo_persona) == 'JURÍDICA' ? 'selected' : '' }}>JURÍDICA</option>
                            </select>
                            <select name="tipo_documento" id="tipo_documento" class="cliente-index-input flex-grow mr-2">
                                <option value="" disabled>Tipo de documento</option>
                                <option value="DNI" {{ old('tipo_documento', $cliente->tipo_documento) == 'DNI' ? 'selected' : '' }}>DNI</option>
                                <option value="RUC" {{ old('tipo_documento', $cliente->tipo_documento) == 'RUC' ? 'selected' : '' }}>RUC</option>
                            </select>
                            <input type="text" name="numero_documento" id="numero_documento" placeholder="Número de documento" value="{{ old('numero_documento', $cliente->numero_documento) }}" maxlength="15" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="cliente-index-input flex-grow">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="flex">
                            <input type="text" name="apellidos_razon_social" id="apellidos_razon_social" placeholder="Apellidos o Razón Social" value="{{ old('apellidos_razon_social', $cliente->apellidos_razon_social) }}" class="cliente-index-input flex-grow mr-2">
                            <input type="text" name="nombres" id="nombres" placeholder="Nombres" value="{{ old('nombres', $cliente->nombres) }}" class="cliente-index-input flex-grow mr-2">
                            <input type="text" name="celular" id="celular" placeholder="Celular" value="{{ old('celular', $cliente->celular) }}" maxlength="15" inputmode="numeric" pattern="[0-9]*" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="cliente-index-input flex-grow">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="flex">
                            <input type="text" name="direccion" id="direccion" placeholder="Dirección" value="{{ old('direccion', $cliente->direccion) }}" class="cliente-index-input">
                        </div>
                    </div>
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
