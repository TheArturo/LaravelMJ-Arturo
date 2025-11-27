<x-layouts.app :title="'PUNTO DE MUEBLERIA JAZMIN'">
    @vite('resources/css/ventas.css')
    <div class="ventas-form-bg">
        <div class="ventas-form-container">
            <div class="mb-4">
                <a href="{{ route('historial_ventas.index') }}" class="btn-info">Ir al historial de ventas</a>
            </div>
            <form id="formVenta" autocomplete="off">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="ventas-form-3col">
                    <!-- Columna 1: Historial y Cliente -->
                    <div class="ventas-col-2 ventas-tarjeta ventas-section cliente-index-form">
                        <h3 class="ventas-tarjeta-titulo">Cliente</h3>
                        <div class="ventas-producto-bloque">
                            <div class="form-group">
                                <label for="numero_documento" class="flex-grow mr-2">DNI / RUC:</label>
                                <div class="flex">
                                    <input type="text" id="numero_documento" name="numero_documento" placeholder="Ingrese DNI / RUC" inputmode="numeric" pattern="[0-9]*" maxlength="15" class="flex-grow mr-2">
                                    <button type="button" id="btnBuscarCliente" class="focus:ring-0">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="ventas-producto-bloque">
                            <label for="tipo_documento" class="flex-grow mr-2">TIPO DE DOCUMENTO:</label>
                            <input type="text" id="tipo_documento" name="tipo_documento" placeholder="TIPO DE DOCUMENTO" class="flex-grow mr-2" readonly>
                            <label for="cliente" class="flex-grow mr-2">CLIENTE:</label>
                            <input type="text" id="cliente" name="cliente" placeholder="CLIENTE" class="flex-grow mr-2" readonly>
                            <label for="direccion" class="flex-grow mr-2">DIRECCIÓN:</label>
                            <input type="text" id="direccion" name="direccion" placeholder="DIRECCIÓN" class="flex-grow" readonly>
                        </div>
                        <div id="mensajeCliente"></div>
                    </div>
                    <!-- Columna 2: Producto -->
                    <div class="ventas-col-2 ventas-tarjeta ventas-section">
                        <div class="ventas-producto-grid">
                            <h3 class="ventas-tarjeta-titulo">Datos del comprobante</h3>
                            <div class="ventas-producto-bloque">
                                <div class="flex gap-16">
                                    <div class="form-group flex-grow">
                                        <label for="id_tipo_comprobante">TIPO DE COMPROBANTE:</label>
                                        <select id="id_tipo_comprobante" name="id_tipo_comprobante" class="ventas-index-input">
                                            <option value="" disabled selected>SELECCIONE COMPROBANTE</option>
                                            <option value="2">BOLETA</option>
                                            <option value="1">FACTURA</option>
                                        </select>
                                    </div>
                                    <div class="form-group flex-grow">
                                        <label for="fecha_emision">FECHA DE EMISIÓN:</label>
                                        <input type="date" id="fecha_emision" name="fecha_emision" class="fecha-emision" value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                    <div class="form-group flex-grow">
                                        <label for="hora_emision">HORA DE EMISIÓN:</label>
                                        <input type="time" id="hora_emision" name="hora_emision" class="fecha-emision" readonly>
                                    </div>
                                </div>
                                <div class="flex gap-16">
                                    <div class="form-group flex-grow">
                                        <label for="serie">SERIE DE COMPROBANTE:</label>
                                        <input type="text" id="serie" name="serie" placeholder="SERIE DE COMPROBANTE" readonly>
                                    </div>
                                    <div class="form-group flex-grow">
                                        <label for="numero_comprobante">NÚMERO DE COMPROBANTE:</label>
                                        <input type="text" id="numero_comprobante" name="numero_comprobante" placeholder="NÚMERO DE COMPROBANTE" readonly>
                                    </div>
                                </div>
                                <label for="medio_pago">MEDIO DE PAGO:</label>
                                <select id="medio_pago" name="medio_pago" class="ventas-index-input">
                                    <option value="" disabled selected>SELECCIONE MEDIO DE PAGO</option>
                                    <option value="CONTADO">CONTADO</option>
                                    <option value="CREDITO">CREDITO</option>
                                </select>
                            </div>
                            <div id="mensajeComprobante"></div>
                            <h3 class="ventas-tarjeta-titulo">Producto</h3>
                            <div class="ventas-producto-bloque">
                                <div class="form-group">
                                    <label for="codigo" class="flex-grow mr-2">CÓDIGO DEL PRODUCTO:</label>
                                    <div class="flex">
                                        <input type="text" id="codigo" name="codigo" placeholder="INGRESE CÓDIGO DEL PRODUCTO" inputmode="numeric" pattern="[0-9]*" maxlength="15class="flex-grow mr-2">
                                        <button type="button" id="btnBuscarProducto">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="ventas-producto-bloque">
                                <label for="nombre_producto">NOMBRE PRODUCTO:</label>
                                <input type="text" id="nombre_producto" name="nombre_producto"placeholder="NOMBRE PRODUCTO" readonly>
                                <div class="flex gap-16">
                                <div class="form-group flex-grow">
                                    <label for="precio">PRECIO:</label>
                                    <input type="number" id="precio" name="precio" placeholder="PRECIO" readonly>
                                </div>
                                <div class="form-group flex-grow">
                                    <label for="stock">STOCK:</label>
                                    <input type="number" id="stock" name="stock" placeholder="STOCK" readonly>
                                </div>
                                </div>
                            </div>
                            <div class="ventas-producto-bloque">
                                <label for="cantidad">CANTIDAD:</label>
                                <input type="number" id="cantidad" name="cantidad" min="1"
                                    placeholder="CANTIDAD">
                                <button type="button" id="btnAgregarCarrito">Agregar al carrito</button>
                            </div>
                        </div>
                        <div id="mensajeProducto"></div>
                    </div>
                    <!-- Columna 3: Total y Botones -->
                    <div class="ventas-col-3 ventas-tarjeta ventas-section ventas-tarjeta-total">
                        <h3 class="ventas-tarjeta-titulo">Total</h3>
                        <div class="ventas-form-botones">
                            <button type="submit" id="btnGenerarVenta">Venta</button>
                            <button type="button" id="btnCancelar">Cancelar</button>
                        </div>
                    </div>
                </div>
                <div class="ventas-form-row ventas-form-tabla">
                    <div style="width:100%;">
                        <table class="table-ventas">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="carritoBody"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>TOTAL</td>
                                    <td><input type="text" id="total_pagar" name="total_pagar" readonly></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
            </form>
        </div>
    </div>
    <!-- LOADER VA AQUÍ -->
    <div id="loaderVenta" class="loader-venta" style="display:none;">
        <div class="spinner"></div>
        <p>Procesando venta, por favor espere...</p>
    </div>
    @vite('resources/js/ventas.js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-layouts.app>
