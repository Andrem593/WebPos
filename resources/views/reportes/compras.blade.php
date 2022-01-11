<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Reporte de Compras') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tabla de Compras') }}
                            </span>

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <h4 class="text-bold">Filtros de Fechas</h4>
                        <form method="get">
                            <div class="row">
                                <div class="col">
                                    <div class="">
                                        <label for="desde" class="form-label">Desde:</label>
                                        <input type="date" name="desde" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="">
                                        <label for="hasta" class="form-label">Hasta:</label>
                                        <input type="date" name="hasta" class="form-control">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-outline-success" type="submit"
                                        style="margin-top: 32px">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-striped table-hover">
                                <thead class="thead bg-secondary">
                                    <tr>

                                        <th>NO FACTURA</th>

                                        <th>CODIGO BARRAS</th>
                                        <th>NOMBRE PRODUCTO</th>
                                        <th>RUC</th>
                                        <th>NOMBRE PROVEEDOR</th>
                                        <th>CANTIDAD</th>
                                        <th>COSTO UNITARIO</th>
                                        <th>COSTO TOTAL</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_factura = 0
                                    @endphp
                                    @foreach ($compras as $compra)
                                        <tr>
                                            <td>{{ $compra->numero_factura }}</td>
                                            <td>{{ $compra->codigo_barras }}</td>
                                            <td>{{ $compra->nombre_producto }}</td>
                                            <td>{{ $compra->ruc_proveedor }}</td>
                                            <td>{{ $compra->nombre_proveedor }}</td>
                                            <td>{{ $compra->cantidad }}</td>
                                            <td>${{ number_format($compra->costo_proveedor, 2) }}</td>
                                            <td>${{ number_format($compra->total_factura, 2) }}</td>
                                            <td><a href="{{route('compras.edit',$compra->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a></td>
                                        </tr>
                                        @php
                                            $total_factura += $compra->total_factura;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>TOTAL</th>
                                        <th>${{ number_format($total_factura, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="/css/botonesDataTable.css">
    @endpush
    @push('js')
        <script src="../js/crearDataTable.js"></script>
    @endpush
</x-app-layout>
