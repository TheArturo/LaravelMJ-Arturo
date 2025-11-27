<?php

namespace Src\Ventas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Ventas\Repositories\VentaRepository;
use Illuminate\Support\Facades\Auth;
use Src\Ventas\Services\NubefactService;

class VentaController extends Controller
{
    protected $ventas;

    public function __construct(VentaRepository $ventas)
    {
        $this->ventas = $ventas;
    }

    public function index(Request $request)
    {
        $filters = [
            'fecha_desde'       => $request->input('fecha_desde'),
            'fecha_hasta'       => $request->input('fecha_hasta'),
            'tipo_comprobante'  => $request->input('tipo_comprobante'),
            'numero_comprobante'=> $request->input('numero_comprobante'),
            'documento'         => $request->input('documento'),
            'cliente'           => $request->input('cliente'),
            'estado_sunat'      => $request->input('estado_sunat'),
        ];

        $ventas = $this->ventas->all($filters);

        return view('modulos.historial_ventas.index', compact('ventas', 'filters'));
    }


    public function show($id)
    {
        $venta = $this->ventas->find($id);
        return view('modulos.historial_ventas.show', compact('venta'));
    }
    public function store(Request $request)
    {
        $isJson = $request->expectsJson() || $request->isJson();
        $numero_documento = $request->input('numero_documento');
        $cliente = \Src\Cliente\Models\Cliente::where('numero_documento', $numero_documento)->first();
        if (!$cliente) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Cliente no encontrado'], 422);
            return redirect()->back()->with('error', 'Cliente no encontrado');
        }
        $carrito = $request->input('carrito');
        if (is_string($carrito)) {
            $carrito = json_decode($carrito, true);
        }
        if (!is_array($carrito) || count($carrito) == 0) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Carrito vacío'], 422);
            return redirect()->back()->with('error', 'Carrito vacío');
        }
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        $cantidad_total = array_sum(array_column($carrito, 'cantidad'));
        $existe = \Src\Ventas\Models\Venta::where('cliente_id', $cliente->id)
            ->where('total', $total)
            ->where('cantidad_total', $cantidad_total)
            ->where('created_at', '>=', now()->subSeconds(10))
            ->first();
        if ($existe) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Venta duplicada'], 409);
            return redirect()->back()->with('error', 'Ya existe una venta igual registrada recientemente');
        }
        $venta = new \Src\Ventas\Models\Venta();
        $venta->id_tipo_documento = $request->input('id_tipo_documento');
        $venta->tipo_documento = $request->input('tipo_documento');
        $venta->numero_documento = $request->input('numero_documento'); 
        $venta->cliente_id = $cliente->id;
        $venta->cliente = $request->input('cliente');
        $venta->direccion = $request->input('direccion');
        $venta->id_tipo_comprobante = $request->input('id_tipo_comprobante');
        $venta->tipo_comprobante = $request->input('tipo_comprobante');
        $venta->serie = $request->input('serie');
        $venta->numero_comprobante = $request->input('numero_comprobante');
        $venta->medio_pago = $request->input('medio_pago');
        $venta->fecha = $request->input('fecha_emision');
        $venta->hora = $request->input('hora_emision');
        $venta->cantidad_total = $cantidad_total;
        $venta->igv = $total - ($total / 1.18);
        $venta->sub_total = $total / 1.18;
        $venta->total = $total;
        $venta->usuario_id = Auth::id();
        $venta->save();
        foreach ($carrito as $item) {
            $producto = \Src\Producto\Models\Producto::where('codigo', $item['codigo'])->first();
            if ($producto) {
                $detalle = new \Src\Ventas\Models\DetalleVenta();
                $detalle->venta_id = $venta->id;
                $detalle->producto_id = $producto->id;
                $detalle->codigo_producto = $producto->codigo;
                $detalle->nombre_producto = $producto->nombre;
                $detalle->cliente_nombre = trim($cliente->apellidos_razon_social . ' ' . $cliente->nombres);
                $detalle->usuario_nombre = Auth::user()->name; // Usar el nombre del usuario autenticado
                $detalle->fecha = $venta->fecha;
                $detalle->hora = $venta->hora;
                $detalle->cantidad = $item['cantidad'];
                $detalle->valor_unitario = $item['precio'] / 1.18;
                $detalle->precio_unitario = $item['precio'];
                $detalle->subtotal = ($item['precio'] * $item['cantidad']) / 1.18;
                $detalle->igv = ($item['precio'] * $item['cantidad']) - (($item['precio'] * $item['cantidad']) / 1.18);
                $detalle->total = $item['precio'] * $item['cantidad'];
                $detalle->save();
                // Actualizar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
        }
        
        // ==========================================
        // INICIO ENVIAR COMPROBANTE A NUBEFACT
        // ==========================================

        

        $nubefact = new NubefactService();
        $response = $nubefact->enviarComprobante($venta, $carrito);
        
        // Si Nubefact devolvió errores
        if (isset($response['errors'])) {
            if ($isJson) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error Nubefact',
                    'detalle' => $response['errors']
                ], 500);
            }
            return redirect()->back()->with('error', 'Error al enviar comprobante a Nubefact: ' . $response['errors']);
        }

        // Guardar respuesta de Nubefact (opcional)
        // Aquí podrías crear una tabla comprobantes o guardar en la venta
        $venta->sunat_aceptada = $response['aceptada_por_sunat'] ?? null;
        $venta->sunat_codigo_hash = $response['codigo_hash'] ?? null;
        $venta->sunat_enlace_pdf = $response['enlace_del_pdf'] ?? null;
        $venta->sunat_enlace_xml = $response['enlace_del_xml'] ?? null;
        $venta->sunat_enlace_cdr = $response['enlace_del_cdr'] ?? null;
        $venta->save();

        // ==========================================
        // FIN ENVIAR COMPROBANTE A NUBEFACT
        // ==========================================

        // ==========================================
        // INICIO ACTUALIZAR NUMERO_COMPROBANTE EN T_PARAMS
        // ==========================================

        // Aumenta el correlativo si la API DE nubefact no devolvió errores
        if (!isset($response['errors'])) {
            \Illuminate\Support\Facades\DB::table('t_params')
                ->where('id_tipo_comprobante', $venta->id_tipo_comprobante)
                ->where('serie', $venta->serie)
                ->increment('numero_comprobante', 1);
        }

        // ==========================================
        // FIN ACTUALIZAR NUMERO_COMPROBANTE EN T_PARAMS
        // ==========================================

        // SIEMPRE devolver JSON cuando la petición viene desde fetch()
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'venta_id' => $venta->id
            ]);
        }

        // Si fuera un submit normal (no lo usas)
        return redirect()->route('historial_ventas.index')->with('success', 'Venta generada correctamente');

    }

    public function buscarCliente(Request $request)
    {
        $numero_documento = $request->query('numero_documento');
        $cliente = \Src\Cliente\Models\Cliente::where('numero_documento', $numero_documento)->first();
        if ($cliente) {
            return response()->json([
                'success' => true,
                'tipo_documento' => $cliente->tipo_documento,
                'cliente' => trim($cliente->apellidos_razon_social . ' ' . $cliente->nombres),
                'direccion' => $cliente->direccion
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function buscarProducto(Request $request)
    {
        $codigo = trim($request->query('codigo'));
        $producto = \Src\Producto\Models\Producto::where('codigo', $codigo)->first();
        if ($producto) {
            return response()->json([
                'success' => true,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function buscarComprobante(Request $request)
    {
        $id_tipo_comprobante = trim($request->query('id_tipo_comprobante'));
        $t_params = \Src\Ventas\Models\Param::where('id_tipo_comprobante', $id_tipo_comprobante)->first();
        if ($t_params) {
            return response()->json([
                'success' => true,
                'id_tipo_comprobante' => $t_params->id_tipo_comprobante,
                'tipo_comprobante' => $t_params->tipo_comprobante,
                'serie' => $t_params->serie,
                'numero_comprobante' => $t_params->numero_comprobante,
            ]);
        }
        return response()->json(['success' => false]);
    }
}
