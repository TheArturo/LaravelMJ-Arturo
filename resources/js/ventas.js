document.addEventListener('DOMContentLoaded', function() {
    // Restaurar datos de la venta desde sessionStorage
    function restaurarDatosVenta() {
        const campos = [
            ['venta_dni', 'dni'],
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

    // Buscar cliente por DNI
    document.getElementById('btnBuscarCliente').addEventListener('click', function() {
        const dni = document.getElementById('dni').value.trim();
        const nombreInput = document.getElementById('nombre');
        const mensaje = document.getElementById('mensajeCliente');
        if (!dni) {
            nombreInput.value = '';
            mensaje.textContent = 'Ingrese un DNI válido';
            sessionStorage.removeItem('venta_dni');
            sessionStorage.removeItem('venta_nombre');
            return;
        }
        fetch(`/ventas/buscar-cliente?dni=${dni}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    nombreInput.value = data.nombre;
                    mensaje.textContent = '';
                    sessionStorage.setItem('venta_dni', dni);
                    sessionStorage.setItem('venta_nombre', data.nombre);
                } else {
                    nombreInput.value = '';
                    mensaje.textContent = 'Cliente no encontrado';
                    sessionStorage.removeItem('venta_dni');
                    sessionStorage.removeItem('venta_nombre');
                }
            })
            .catch(() => {
                nombreInput.value = '';
                mensaje.textContent = 'Error al buscar cliente';
                sessionStorage.removeItem('venta_dni');
                sessionStorage.removeItem('venta_nombre');
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
    // ...existing code...
    // Limpiar carrito y datos al generar venta
    const btnGenerarVenta = document.getElementById('btnGenerarVenta');
    if (btnGenerarVenta) {
        btnGenerarVenta.addEventListener('click', function(e) {
            e.preventDefault();
            const dni = document.getElementById('dni').value.trim();
            if (!dni) {
                alert('Debe ingresar el DNI del cliente');
                return;
            }
            if (!carrito.length) {
                alert('El carrito está vacío');
                return;
            }
            // Usar FormData para enviar como formulario normal
            const formData = new FormData();
            formData.append('dni', dni);
            formData.append('carrito', JSON.stringify(carrito));
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            fetch('/ventas', {
                method: 'POST',
                body: formData
            })
            .then(res => res.redirected ? window.location.href = res.url : res.json())
            .then(data => {
                if (data && data.success) {
                    alert('Venta generada correctamente');
                }
                carrito = [];
                sessionStorage.removeItem('carrito_venta');
                ['venta_dni','venta_nombre','venta_codigo','venta_nombre_producto','venta_precio','venta_stock'].forEach(k => sessionStorage.removeItem(k));
                renderCarrito();
                document.getElementById('formVenta').reset();
                document.getElementById('total_pagar').value = '';
            })
            .catch(() => {
                alert('Error al generar la venta');
            });
        });
    }
    }

    document.getElementById('btnCancelar').addEventListener('click', function() {
    carrito = [];
    sessionStorage.removeItem('carrito_venta');
    renderCarrito();
    document.getElementById('formVenta').reset();
    document.getElementById('total_pagar').value = '';
    });
});
