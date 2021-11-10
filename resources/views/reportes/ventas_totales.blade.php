<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Lista de Ventas') }}
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
                                        <th width="10px">ID</th>
                                        <th  width="15px">CANTIDAD</th>
                                        <th>SUBTOTAL</th>
                                        <th>IMPUESTO</th>
                                        <th>TOTAL</th>
                                        <th>VENDEDOR</th>
                                        <th>FECHA</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_venta = 0;
                                    @endphp
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->id }}</td>
                                            <td><center>{{ $venta->cantidad_total }}</center></td>

                                            <td>${{ number_format($venta->subtotal, 2) }}</td>
                                            <td>${{ number_format($venta->impuesto, 2) }}</td>
                                            <td>${{ number_format($venta->total, 2) }}</td>
                                            <td>{{ $venta->usuario }}</td>
                                            <td>{{ date_format(date_create($venta->created_at), 'd-m-Y') }}</td>
                                            <td>
                                                <a type='button' class="eliminar btn btn-danger btn-sm"
                                                    data-toggle="modal" data-target="#eliminar"><i
                                                        class="fa fa-fw fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @php
                                            $total_venta += $venta->total;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>TOTAL</th>
                                        <th>${{ number_format($total_venta, 2) }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Elemento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </symbol>
                    </svg>
                    <div class="alert alert-warning  d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            Eliminar la cantidad de un producto que ya ha sido vendido puede afectar tu inventario real
                        </div>
                    </div>
                    <div class="form-group mx-auto text-center">
                        <label for="">¿Estas seguro de eliminar la Venta?</label>
                        <input type="hidden" id="id_venta">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="eliminar_venta" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="/css/botonesDataTable.css">
    @endpush
    @push('js')
        <script src="../js/crearDataTable.js"></script>
        <script>
            $("#eliminar_venta").on('click', function() {
                let datos = {
                    id_venta: $("#id_venta").val(),
                    funcion: 'eliminar_venta_total'
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('pedido.editarVentas') }}",
                    method: 'post',
                    data: datos,
                    success: function(data) {
                        Swal.fire(
                            'Eliminado !',
                            data.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.href = 'http://localhost:8000/reporte/ventas';
                            }
                        })
                    }
                })
            });

        </script>
    @endpush
</x-app-layout>
