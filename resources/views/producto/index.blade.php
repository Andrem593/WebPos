<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Tabla de Producto') }}
                            </span>

                            <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Crear Nuevo') }}
                                </a>
                            </div>
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
                                        <th>No</th>

                                        <th>Codigo Barras</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Stock</th>
                                        <th>Categoria</th>
                                        <th>Proveedor</th>
                                        <th>Precio</th>
                                        <th>Costo</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->id }}</td>

                                            <td>{{ $producto->codigo_barras }}</td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->descripcion }}</td>
                                            <td>{{ $producto->cantidad }}</td>
                                            <td>{{ $producto->stock }}</td>
                                            <td>{{ $producto->nombre_categoria }}</td>
                                            <td>{{ $producto->nombre_proveedor }}</td>
                                            <td>${{ number_format($producto->precio,2) }}</td>
                                            <td>${{ number_format($producto->costo_proveedor,2) }}</td>

                                            <td>
                                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('productos.show', $producto->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('productos.edit', $producto->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
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
        <script src="js/crearDataTable.js"></script>
    @endpush
</x-app-layout>
