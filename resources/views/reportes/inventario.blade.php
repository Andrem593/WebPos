<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Inventario') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tabla de inventario') }}
                            </span>

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-striped table-hover">
                                <thead class="thead bg-secondary">
                                    <tr>
                                        <th>CODIGO</th>
                                        <th>PRODUCTO</th>
                                        <th>DESCRIPCION</th>
                                        <th>CANTIDAD</th>
                                        <th>STOCK</th>
                                        <th>CATEGORIA</th>
                                        <th>PROVEEDOR</th>
                                        <th>PRECIO</th>
                                        <th>COSTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->codigo_barras }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->descripcion }}</td>
                                            <td>{{ $producto->cantidad }}</td>
                                            <td>{{ $producto->stock }}</td>
                                            <td>{{ $producto->nombre_categoria }}</td>
                                            <td>{{ $producto->nombre_proveedor }}</td>
                                            <td>${{ number_format($producto->precio,2) }}</td>
                                            <td>${{ number_format($producto->costo_proveedor,2) }}</td>
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
