<?php
namespace Src\Ventas\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Src\Ventas\Repositories\VentaRepository;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    protected $ventas;

    public function __construct(VentaRepository $ventas)
    {
        $this->ventas = $ventas;
    }

    public function index()
    {
        $ventas = $this->ventas->all();
        return view('modulos.historial_ventas.index', compact('ventas'));
    }

    public function show($id)
    {
        $venta = $this->ventas->find($id);
        return view('modulos.historial_ventas.show', compact('venta'));
    }
    public function store(Request $request)
    {
        // Permitir JSON (AJAX) y formulario clásico
        $isJson = $request->expectsJson() || $request->isJson();
        $dni = $request->input('dni');
        $cliente = \Src\Cliente\Models\Cliente::where('dni', $dni)->first();
        if (!$cliente) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Cliente no encontrado'], 422);
            return redirect()->back()->with('error', 'Cliente no encontrado');
        }
        // Evitar duplicados: buscar venta igual
        $existe = \Src\Ventas\Models\Venta::where('cliente_id', $cliente->id)
            ->where('fecha', date('Y-m-d'))
            ->where('hora', date('H:i:s'))
            ->first();
        if ($existe) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Venta duplicada'], 409);
            return redirect()->back()->with('error', 'Ya existe una venta igual registrada');
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
    $venta = new \Src\Ventas\Models\Venta();
    $venta->cliente_id = $cliente->id;
    $venta->fecha = date('Y-m-d');
    $venta->hora = date('H:i:s');
    $venta->cantidad_total = array_sum(array_column($carrito, 'cantidad'));
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
                $detalle->cliente_nombre = $cliente->nombre . ' ' . $cliente->apellido;
                $detalle->usuario_nombre = 'admin';
                $detalle->fecha = $venta->fecha;
                $detalle->hora = $venta->hora;
                $detalle->cantidad = $item['cantidad'];
                $detalle->precio_unitario = $item['precio'];
                $detalle->subtotal = $item['precio'] * $item['cantidad'];
                $detalle->save();
                // Actualizar stock
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }
        }
        if ($isJson) return response()->json(['success' => true, 'venta_id' => $venta->id]);
        return redirect()->route('historial_ventas.index')->with('success', 'Venta generada correctamente');
    }

    public function buscarCliente(Request $request)
    {
        $dni = $request->query('dni');
        $cliente = \Src\Cliente\Models\Cliente::where('dni', $dni)->first();
        if ($cliente) {
            return response()->json([
                'success' => true,
                'nombre' => $cliente->nombre . ' ' . $cliente->apellido,
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
}
