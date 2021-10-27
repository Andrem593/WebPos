<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Buscar Producto</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form id="add_producto" method="POST" action="{{ route('pedido.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Busquedad</label>
                                    <div class="input-group">
                                        <input type="search" id="buscar" name="producto"
                                            class="form-control form-control-lg"
                                            placeholder="Escribe el nombre del producto o codigo de barras">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" id="cantidad"
                                    placeholder="Ingresa la cantidad del producto">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Detalle del Pedido</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <strong class="my-1">CANTIDAD: </strong>
                            {{ Cart::count() }}
                        </div>
                        <div class="form-group">
                            <strong class="my-1">SUBTOTAL: </strong>
                            ${{ Cart::subtotal() }}
                        </div>
                        <div class="form-group">
                            <strong class="my-1">IVA 12%: </strong>
                            ${{ Cart::tax() }}
                        </div>
                        <div class="form-group">
                            <strong class="my-1">TOTAL: </strong>
                            ${{ Cart::total() }}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">

            <div class="table-responsive">
                <table id="datatable" class="display table table-striped table-hover">
                    <thead class="thead bg-primary">
                        <tr>
                            <th>No</th>

                            <th>Codigo Barras</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>PVP</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Cart::count() > 0)
                        {{ $i = 0}}
                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{$item->options->codigo_barras  }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>${{ number_format($item->price,2) }}</td>
                                    <td>${{ number_format(($item->price * $item->qty),2) }}</td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="/css/botonesDataTable.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
            integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
            integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="js/crearDataTable.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
            $('#buscar').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search.productos') }}",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    })
                }
            })

        </script>
    @endpush
</x-app-layout>
