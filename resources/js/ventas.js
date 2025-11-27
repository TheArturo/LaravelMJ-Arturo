document.addEventListener('DOMContentLoaded', function() {
    // Restaurar datos de la venta desde sessionStorage
    function restaurarDatosVenta() {
        const campos = [
            ['venta_numero_documento', 'numero_documento'],
            ['venta_nombre', 'nombre'],
            ['venta_codigo', 'codigo'],
            ['venta_nombre_producto', 'nombre_producto'],
            ['venta_precio', 'precio'],
            ['venta_stock', 'stock']
        ];
        campos.forEach(([key, id]) => {
            if (sessionStorage.getItem(key)) {
                document.getElementById(id).value = sessionStorage.getItem(key);
            }
        });
    }
    restaurarDatosVenta();
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) restaurarDatosVenta();
    });

    // Buscar por id tipo de documento
    document.getElementById('id_tipo_comprobante').addEventListener('change', function() {
        console.log("Valor seleccionado:", this.value);
        const id_tipo_comprobante = document.getElementById('id_tipo_comprobante');
        const serie = document.getElementById('serie');
        const numero_comprobante = document.getElementById('numero_comprobante');
        const mensaje = document.getElementById('mensajeComprobante');
        if (!id_tipo_comprobante.value) {
            serie.value = '';
            numero_comprobante.value = '';
            mensaje.textContent = 'Seleccione un tipo de comprobante';
            sessionStorage.removeItem('venta_serie');
            sessionStorage.removeItem('venta_numero_comprobante');
            return;
        }
        fetch(`/ventas/buscar-comprobante?id_tipo_comprobante=${id_tipo_comprobante.value}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log(data);
                    serie.value = data.serie;
                    numero_comprobante.value = data.numero_comprobante;
                    mensaje.textContent = '';
                    sessionStorage.setItem('venta_serie', data.serie);
                    sessionStorage.setItem('venta_numero_comprobante', data.numero_comprobante);
                } else {
                    serie.value = '';
                    numero_comprobante.value = '';
                    mensaje.textContent = 'Datos no encontrados';
                    sessionStorage.setItem('venta_serie');
                    sessionStorage.setItem('venta_numero_comprobante');
                }
            })
            .catch(() => {
                serie.value = '';
                numero_comprobante.value = '';
                mensaje.textContent = 'Error al buscar tipo de comprobante';
                sessionStorage.setItem('venta_serie');
                sessionStorage.setItem('venta_numero_comprobante');
            });
    });

    // Buscar cliente por número de documento
    document.getElementById('btnBuscarCliente').addEventListener('click', function() {
        const numero_documento = document.getElementById('numero_documento').value.trim();
        const clienteInput = document.getElementById('cliente');
        const direccionInput = document.getElementById('direccion');
        const tipoDocumentoInput = document.getElementById('tipo_documento');
        const mensaje = document.getElementById('mensajeCliente');
        if (!numero_documento) {
            clienteInput.value = '';
            direccionInput.value = '';
            tipoDocumentoInput.value = '';
            mensaje.textContent = 'Ingrese número de documento válido';
            sessionStorage.removeItem('venta_numero_documento');
            sessionStorage.removeItem('venta_cliente');
            sessionStorage.removeItem('venta_direccion');
            sessionStorage.removeItem('venta_tipo_documento');
            return;
        }
        fetch(`/ventas/buscar-cliente?numero_documento=${numero_documento}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    clienteInput.value = data.cliente;
                    direccionInput.value = data.direccion;
                    tipoDocumentoInput.value = data.tipo_documento;
                    mensaje.textContent = '';
                    sessionStorage.setItem('venta_numero_documento', numero_documento);
                    sessionStorage.setItem('venta_cliente', data.cliente);
                    sessionStorage.setItem('venta_direccion', data.direccion);
                    sessionStorage.setItem('venta_tipo_documento', data.tipo_documento);
                } else {
                    clienteInput.value = '';
                    direccionInput.value = '';
                    tipoDocumentoInput.value = '';
                    mensaje.textContent = 'Datos no encontrados';
                    sessionStorage.removeItem('venta_numero_documento');
                    sessionStorage.removeItem('venta_cliente');
                    sessionStorage.removeItem('venta_direccion');
                    sessionStorage.removeItem('venta_tipo_documento');
                }
            })
            .catch(() => {
                clienteInput.value = '';
                direccionInput.value = '';
                tipoDocumentoInput.value = '';
                mensaje.textContent = 'Error al buscar cliente';
                sessionStorage.removeItem('venta_numero_documento');
                sessionStorage.removeItem('venta_cliente');
                sessionStorage.removeItem('venta_direccion');
                sessionStorage.removeItem('venta_tipo_documento');
            });
    });

    // Buscar producto por código
    document.getElementById('btnBuscarProducto').addEventListener('click', function() {
        const codigo = document.getElementById('codigo').value.trim();
        const nombreInput = document.getElementById('nombre_producto');
        const precioInput = document.getElementById('precio');
        const stockInput = document.getElementById('stock');
        const cantidadInput = document.getElementById('cantidad');
        const mensaje = document.getElementById('mensajeProducto');
        if (!codigo) {
            nombreInput.value = '';
            precioInput.value = '';
            stockInput.value = '';
            cantidadInput.value = '';
            cantidadInput.disabled = true;
            mensaje.textContent = 'Ingrese un código válido';
            sessionStorage.removeItem('venta_codigo');
            sessionStorage.removeItem('venta_nombre_producto');
            sessionStorage.removeItem('venta_precio');
            sessionStorage.removeItem('venta_stock');
            return;
        }
        fetch(`/ventas/buscar-producto?codigo=${codigo}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    nombreInput.value = data.nombre;
                    precioInput.value = data.precio;
                    stockInput.value = data.stock;
                    cantidadInput.disabled = false;
                    mensaje.textContent = '';
                    sessionStorage.setItem('venta_codigo', codigo);
                    sessionStorage.setItem('venta_nombre_producto', data.nombre);
                    sessionStorage.setItem('venta_precio', data.precio);
                    sessionStorage.setItem('venta_stock', data.stock);
                } else {
                    nombreInput.value = '';
                    precioInput.value = '';
                    stockInput.value = '';
                    cantidadInput.value = '';
                    cantidadInput.disabled = true;
                    mensaje.textContent = 'Producto no encontrado';
                    sessionStorage.removeItem('venta_codigo');
                    sessionStorage.removeItem('venta_nombre_producto');
                    sessionStorage.removeItem('venta_precio');
                    sessionStorage.removeItem('venta_stock');
                }
            })
            .catch(() => {
                nombreInput.value = '';
                precioInput.value = '';
                stockInput.value = '';
                cantidadInput.value = '';
                cantidadInput.disabled = true;
                mensaje.textContent = 'Error al buscar producto';
                sessionStorage.removeItem('venta_codigo');
                sessionStorage.removeItem('venta_nombre_producto');
                sessionStorage.removeItem('venta_precio');
                sessionStorage.removeItem('venta_stock');
            });
    });

    // Carrito persistente
    let carrito = [];
    // Al cargar, restaurar carrito si existe
    if (sessionStorage.getItem('carrito_venta')) {
        try {
            carrito = JSON.parse(sessionStorage.getItem('carrito_venta')) || [];
        } catch(e) {
            carrito = [];
        }
    }
    renderCarrito();

    document.getElementById('btnAgregarCarrito').addEventListener('click', function() {
        const codigo = document.getElementById('codigo').value;
        const nombre = document.getElementById('nombre_producto').value;
        const precio = parseFloat(document.getElementById('precio').value);
        const cantidad = parseInt(document.getElementById('cantidad').value);
        const stock = parseInt(document.getElementById('stock').value);
        if (!codigo || !nombre || isNaN(precio) || isNaN(cantidad) || cantidad < 1) {
            alert('Completa los datos del producto y cantidad válida');
            return;
        }
        if (cantidad > stock) {
            alert('No hay suficiente stock disponible');
            return;
        }
        const total = precio * cantidad;
        carrito.push({ codigo, nombre, precio, cantidad, total });
        sessionStorage.setItem('carrito_venta', JSON.stringify(carrito));
        renderCarrito();
        document.getElementById('cantidad').value = '';
    });

    function renderCarrito() {
        const tbody = document.getElementById('carritoBody');
        tbody.innerHTML = '';
        let totalPagar = 0;
        carrito.forEach((item, idx) => {
            totalPagar += item.total;
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${idx+1}</td><td>${item.codigo}</td><td>${item.nombre}</td><td>${item.cantidad}</td><td>${item.precio}</td><td>${item.total.toFixed(2)}</td><td><button type='button' class='btnEliminar' data-idx='${idx}'>Eliminar</button></td>`;
            tbody.appendChild(tr);
        });
        document.getElementById('total_pagar').value = totalPagar.toFixed(2);
        // Botón eliminar producto del carrito
        document.querySelectorAll('.btnEliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-idx'));
                carrito.splice(idx, 1);
                sessionStorage.setItem('carrito_venta', JSON.stringify(carrito));
                renderCarrito();
            });
        });
    }

    // ...existing code...
    // Limpiar carrito y datos al generar venta
    const btnGenerarVenta = document.getElementById('btnGenerarVenta');
    if (btnGenerarVenta) {
        btnGenerarVenta.addEventListener('click', function(e) {
            e.preventDefault();
            const numero_documento = document.getElementById('numero_documento').value.trim();
            if (!numero_documento) {
                alert('Debe ingresar el numero_documento del cliente');
                return;
            }
            if (!carrito.length) {
                alert('El carrito está vacío');
                return;
            }
            // Usar FormData para enviar como formulario normal
            const formData = new FormData();
            formData.append('numero_documento', numero_documento);
            formData.append('carrito', JSON.stringify(carrito));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // --- Capturar datos del formulario ---
            const tipo_documento = document.getElementById('tipo_documento').value;

            // --- Convertir tipo de documento a ID ---
            let id_tipo_documento = '';
            if (tipo_documento == 'DNI') id_tipo_documento = '1';
            if (tipo_documento == 'RUC') id_tipo_documento = '6';
            
            const cliente = document.getElementById('cliente').value;
            const direccion = document.getElementById('direccion').value;
            const id_tipo_comprobante = document.getElementById('id_tipo_comprobante').value;

            let tipo_comprobante = '';
            if (id_tipo_comprobante == 1) tipo_comprobante = 'FACTURA';
            if (id_tipo_comprobante == 2) tipo_comprobante = 'BOLETA';
            console.log(tipo_comprobante);

            const serie = document.getElementById('serie').value;
            const numero_comprobante = document.getElementById('numero_comprobante').value;
            const medio_pago = document.getElementById('medio_pago').value;
            const fecha_emision = document.getElementById('fecha_emision').value;
            const hora_emision = document.getElementById('hora_emision').value;    

            // --- Añadir datos al FormData ---
            formData.append('id_tipo_documento', id_tipo_documento);
            formData.append('tipo_documento', tipo_documento);
            formData.append('cliente', cliente);
            formData.append('direccion', direccion);
            formData.append('id_tipo_comprobante', id_tipo_comprobante);
            formData.append('tipo_comprobante', tipo_comprobante);
            formData.append('serie', serie);
            formData.append('numero_comprobante', numero_comprobante);
            formData.append('medio_pago', medio_pago);
            formData.append('fecha_emision', fecha_emision);
            formData.append('hora_emision', hora_emision);

            // Mostrar loader
            document.getElementById('loaderVenta').style.display = "flex";

            fetch('/ventas', {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(res => res.redirected ? window.location.href = res.url : res.json())
            .then(data => {

                // Ocultar loader
                document.getElementById('loaderVenta').style.display = "none";

                if (data && data.success) {

                    Swal.fire({
                        title: "Venta generada correctamente",
                        text: "El comprobante fue registrado exitosamente.",
                        icon: "success",
                        confirmButtonText: "Ir al historial"
                    }).then(() => {
                        window.location.href = "/historial-ventas"; // Ajusta ruta
                    });

                } else {

                    Swal.fire({
                        title: "Error al generar la venta",
                        html: `<b>Detalle:</b><br>${data?.error ?? 'No disponible'}`,
                        icon: "error",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#d33"
                    });
                }

                // Reset de carrito y formulario
                carrito = [];
                sessionStorage.removeItem('carrito_venta');
                [
                    'venta_numero_documento',
                    'venta_nombre',
                    'venta_codigo',
                    'venta_nombre_producto',
                    'venta_precio',
                    'venta_stock'
                ].forEach(k => sessionStorage.removeItem(k));

                renderCarrito();
                document.getElementById('formVenta').reset();
                document.getElementById('total_pagar').value = '';

            })
            .catch((err) => {

                document.getElementById('loaderVenta').style.display = "none";

                Swal.fire({
                    title: "Error inesperado",
                    text: "No se pudo completar la venta. Intente nuevamente.",
                    icon: "error",
                    confirmButtonText: "Cerrar",
                    confirmButtonColor: "#d33"
                });

                console.error(err);
            });


        });
    }
    

    document.getElementById('btnCancelar').addEventListener('click', function() {
    carrito = [];
    sessionStorage.removeItem('carrito_venta');
    renderCarrito();
    document.getElementById('formVenta').reset();
    document.getElementById('total_pagar').value = '';
    });

    // Actualizar hora en tiempo real
    const horaEmisionInput = document.getElementById('hora_emision');
    if (horaEmisionInput) {
        function actualizarHora() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            horaEmisionInput.value = `${hours}:${minutes}:${seconds}`;
        }
        actualizarHora(); // Actualiza la hora inmediatamente al cargar
        setInterval(actualizarHora, 1000); // Y luego cada segundo
    }
    
});
