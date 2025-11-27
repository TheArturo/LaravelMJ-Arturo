<?php

namespace Src\Ventas\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NubefactService
{
    protected $ruta;
    protected $token;

    public function __construct()
    {
        $this->ruta = env('NUBEFACT_RUTA');
        $this->token = env('NUBEFACT_TOKEN');
    }

    public function enviarComprobante($venta, $detalles)
    {
        $json = $this->crearJson($venta, $detalles);

        // Log para ver el json enviado
        Log::info("Nubefact JSON enviado:", $json);

        try {

            $response = Http::withHeaders([
                'Authorization' => 'Token token=' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->ruta, $json);

            // Log de respuesta
            Log::info("Nubefact respuesta:", [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            // Si status no es 200, error
            if ($response->failed()) {
                return [
                    'errors' => $response->body()
                ];
            }

            return $response->json();

        } catch (\Exception $e) {

            Log::error("Error Nubefact Exception: " . $e->getMessage());

            return [
                'errors' => $e->getMessage()
            ];
        }
    }

    private function crearJson($venta, $detalles)
    {
        return [
            "operacion" => "generar_comprobante",
            "tipo_de_comprobante" => $venta->id_tipo_comprobante,
            "serie" => $venta->serie,
            "numero" => $venta->numero_comprobante,
            "cliente_tipo_de_documento" => $venta->id_tipo_documento,
            "cliente_numero_de_documento" => $venta->numero_documento,
            "cliente_denominacion" => $venta->cliente,
            "cliente_direccion" => $venta->direccion,
            "fecha_de_emision" => date('d-m-Y', strtotime($venta->fecha)),
            "moneda" => "1",
            "porcentaje_de_igv" => "18",
            "total_gravada" => $venta->sub_total,
            "total_igv" => $venta->igv,
            "total" => $venta->total,
            "tipo_de_operacion" => "0101",
            "enviar_automaticamente_a_la_sunat" => true,
            "enviar_automaticamente_al_cliente" => false,
            "items" => $this->mapearItems($detalles)
        ];
    }

    private function mapearItems($detalles)
    {
        $items = [];

        foreach ($detalles as $d) {

            $subtotal = ($d['precio'] * $d['cantidad']) / 1.18;
            $igv = ($d['precio'] * $d['cantidad']) - $subtotal;

            $items[] = [
                "unidad_de_medida" => "NIU",
                "codigo" => $d['codigo'],
                "descripcion" => $d['nombre'] ?? 'Producto',
                "cantidad" => $d['cantidad'],
                "valor_unitario" => $d['precio'] / 1.18,
                "precio_unitario" => $d['precio'],
                "subtotal" => $subtotal,
                "tipo_de_igv" => "1",
                "igv" => $igv,
                "total" => $d['precio'] * $d['cantidad'],
            ];
        }

        return $items;
    }
}
