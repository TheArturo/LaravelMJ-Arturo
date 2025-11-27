@vite('resources/css/historialventas.css')
<x-layouts.app>
    <div class="container">

        <h2>Historial de Ventas</h2>

        <form method="GET" class="mb-4 p-3 shadow-sm border rounded bg-white">
            <div class="row">
            <div class="flex gap-16">

                <div class="form-group flex-grow">
                    <label for="fecha_desde">FECHA DESDE:</label>
                    <input type="date" name="fecha_desde" class="hventas-index-input" value="{{ $filters['fecha_desde'] ?? '' }}">
                </div>

                <div class="form-group flex-grow">
                    <label for="fecha_hasta">FECHA HASTA:</label>
                    <input type="date" name="fecha_hasta" class="hventas-index-input" value="{{ $filters['fecha_hasta'] ?? '' }}">
                </div>

                <div class="form-group flex-grow">
                    <label for="tipo_comprobante">TIPO DE COMPROBANTE:</label>
                    <input type="text" name="tipo_comprobante" class="hventas-index-input" value="{{ $filters['tipo_comprobante'] ?? '' }}">
                </div>

                <div class="form-group flex-grow">
                    <label for="numero_comprobante">N° COMPROBANTE:</label>
                    <input type="text" name="numero_comprobante" class="hventas-index-input" value="{{ $filters['numero_comprobante'] ?? '' }}">
                </div>
            
            </div>

            <div class="flex gap-16">

                <div class="form-group flex-grow">
                    <label for="documento">DNI / RUC:</label>
                    <input type="text" name="documento" class="hventas-index-input" value="{{ $filters['documento'] ?? '' }}">
                </div>

                <div class="form-group flex-grow">
                    <label for="cliente">CLIENTE:</label>
                    <input type="text" name="cliente" class="hventas-index-input" value="{{ $filters['cliente'] ?? '' }}">
                </div>

                <div class="form-group flex-grow">
                    <label for="estado_sunat">ESTADO SUNAT:</label>
                    <select name="estado_sunat" class="hventas-index-input">
                        <option value="" disabled selected>SELECCIONE ESTADO</option>
                        <option value="1" {{ (isset($filters['estado_sunat']) && $filters['estado_sunat'] == "1") ? 'selected' : '' }}>ENVIADO</option>
                        <option value="0" {{ (isset($filters['estado_sunat']) && $filters['estado_sunat'] == "0") ? 'selected' : '' }}>PENDIENTE</option>
                    </select>
                </div>
            
            </div>

            <div class="flex gap-16">

                <div class="col-md-2 mt-4">
                    <button class="hventas-index-btn hventas-index-btn-search">Buscar</button>
                </div>

                <div class="col-md-2 mt-4">
                    <button class="hventas-index-btn hventas-index-btn-search" disabled>Reporte Excel</button>
                </div>
            
            </div>
            </div>
        </form>


        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha de emisión</th>
                        <th>Hora de emisión</th>
                        <th>Tipo de comprobante</th>
                        <th>Serie</th>
                        <th>Número de comprobante</th>
                        <th>RUC/ DNI</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado SUNAT</th>
                        <th>PDF</th>
                        <th>XML</th>
                        <th>CDR</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $venta->fecha }}</td>
                        <td>{{ $venta->hora }}</td>
                        <td>{{ $venta->tipo_comprobante }}</td>
                        <td>{{ $venta->serie }}</td>
                        <td>{{ $venta->numero_comprobante }}</td>
                        <td>{{ $venta->numero_documento }}</td>
                        <td>{{ $venta->cliente }}</td>
                        <td>{{ $venta->total }}</td>

                        {{-- Estado SUNAT --}}
                        <td>
                            @if($venta->sunat_aceptada == 1)
                                <span class="badge bg-success">Enviado</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </td>

                        {{-- Enlaces PDF / XML / CDR --}}
                        <td>
                            @if($venta->sunat_enlace_pdf)
                                <a href="{{ $venta->sunat_enlace_pdf }}" target="_blank" title="Ver PDF">
                                    📄
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($venta->sunat_enlace_xml)
                                <a href="{{ $venta->sunat_enlace_xml }}" target="_blank" title="Ver XML">
                                    🗂️
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($venta->sunat_enlace_cdr)
                                <a href="{{ $venta->sunat_enlace_cdr }}" target="_blank" title="Ver CDR">
                                    📦
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('historial_ventas.show', $venta->id) }}" class="btn btn-sm btn-primary">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</x-layouts.app>
