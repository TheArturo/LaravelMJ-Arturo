import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/categorias.css',
                'resources/css/productos.css',
                'resources/css/clientes.css',
                'resources/css/proveedores.css',
                'resources/css/ventas.css',
                'resources/css/historial_ventas.css',
                'resources/css/detalle_venta.css',
                'resources/js/app.js',
                'resources/css/historialventas.css',
                'resources/js/ventas.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});