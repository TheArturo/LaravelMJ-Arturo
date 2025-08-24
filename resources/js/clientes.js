// editar ajax
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btnEditar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            fetch(`/clientes/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('dni').value = data.dni || '';
                    document.getElementById('nombre').value = data.nombre || '';
                    document.getElementById('apellido').value = data.apellido || '';
                    document.getElementById('direccion').value = data.direccion || '';
                    document.getElementById('celular').value = data.celular || '';
                    document.getElementById('cliente_id').value = data.id;
                    document.getElementById('inputMethod').value = 'PUT';
                    document.getElementById('formCliente').action = `/clientes/${data.id}`;
                    document.getElementById('btnGuardar').textContent = 'Actualizar';
                });
        });
    });
    // limpiar
    document.getElementById('btnLimpiar').addEventListener('click', function() {
        document.getElementById('dni').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('apellido').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('celular').value = '';
        document.getElementById('cliente_id').value = '';
        document.getElementById('inputMethod').value = 'POST';
        document.getElementById('formCliente').action = '/clientes';
        document.getElementById('btnGuardar').textContent = 'Guardar';
    });
});
