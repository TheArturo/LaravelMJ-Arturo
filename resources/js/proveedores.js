document.addEventListener('DOMContentLoaded', function () {
    const btnLimpiar = document.getElementById('btnLimpiar');
    const formProveedor = document.getElementById('formProveedor');
    if (btnLimpiar && formProveedor) {
        btnLimpiar.addEventListener('click', function () {
            formProveedor.reset();
            // Si usas algún input hidden para id, método, etc, puedes reiniciarlos aquí si es necesario
        });
    }
    // editar ajax
    document.querySelectorAll('.btnEditar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            fetch(`/proveedores/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('ruc').value = data.ruc || '';
                    document.getElementById('nombres').value = data.nombres || '';
                    document.getElementById('telefono').value = data.telefono || '';
                    document.getElementById('direccion').value = data.direccion || '';
                    document.getElementById('razon_social').value = data.razon_social || '';
                    document.getElementById('proveedor_id').value = data.id;
                    document.getElementById('inputMethod').value = 'PUT';
                    document.getElementById('formProveedor').action = `/proveedores/${data.id}`;
                    document.getElementById('btnGuardar').textContent = 'Actualizar';
                });
        });
    });
    // limpiar
    btnLimpiar.addEventListener('click', function() {
        document.getElementById('ruc').value = '';
        document.getElementById('nombres').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('razon_social').value = '';
        document.getElementById('proveedor_id').value = '';
        document.getElementById('inputMethod').value = 'POST';
        formProveedor.action = '/proveedores';
        document.getElementById('btnGuardar').textContent = 'Guardar';
    });
});
