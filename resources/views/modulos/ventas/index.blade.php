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
                    <div class="ventas-col-1 ventas-tarjeta ventas-section">
                        <h3 class="ventas-tarjeta-titulo">Cliente</h3>
                        <label for="dni">DNI CLIENTE:</label>
                        <input type="text" id="dni" name="dni" placeholder="Ingrese DNI"
                            inputmode="numeric" pattern="[0-9]*" maxlength="15">
                        <button type="button" id="btnBuscarCliente">Buscar</button>
                        <input type="text" id="nombre" name="nombre" placeholder="NOMBRE CLIENTE" readonly>
                        <div id="mensajeCliente"></div>
                    </div>
                    <!-- Columna 2: Producto -->
                    <div class="ventas-col-2 ventas-tarjeta ventas-section">
                        <h3 class="ventas-tarjeta-titulo">Producto</h3>
                        <div class="ventas-producto-grid">
                            <div class="ventas-producto-bloque">
                                <label for="codigo">COD PRODUCTO:</label>
                                <input type="text" id="codigo" name="codigo" placeholder="Ingrese código">
                                <button type="button" id="btnBuscarProducto">Buscar</button>
                            </div>
                            <div class="ventas-producto-bloque">
                                <label for="nombre_producto">NOMBRE PRODUCTO:</label>
                                <input type="text" id="nombre_producto" name="nombre_producto"
                                    placeholder="NOMBRE PRODUCTO" readonly>
                                <label for="precio">PRECIO:</label>
                                <input type="number" id="precio" name="precio" placeholder="PRECIO" readonly>
                                <label for="stock">STOCK:</label>
                                <input type="number" id="stock" name="stock" placeholder="STOCK" readonly>
                            </div>
                            <div class="ventas-producto-bloque">
                                <label for="cantidad">CANTIDAD:</label>
                                <input type="number" id="cantidad" name="cantidad" min="1"
                                    placeholder="Cantidad">
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
    @vite('resources/js/ventas.js')
</x-layouts.app>
