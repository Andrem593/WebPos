<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Reporte de Ventas') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tabla de Ventas') }}
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
                                        <th>CODIGO DE BARRAS</th>
                                        <th>CATEGORIA</th>
                                        <th>NOMBRE PRODUCTO</th>
                                        <th>CANTIDAD VENDIDA</th>
                                        <th>PVP</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->codigo_barras }}</td>

                                            <td>{{ $venta->nombre_categoria }}</td>
                                            <td>{{ $venta->nombre_producto }}</td>
                                            <td>{{ $venta->cantidad }}</td>
                                            <td>${{ number_format($venta->precio, 2) }}</td>
                                            <td>${{ number_format($venta->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
