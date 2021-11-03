<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                @livewire('busquedad-producto')
            </div>
            <div class="col">
                @livewire('destalle-pedido')
            </div>
        </div>
        <div class="row">
            @livewire('tabla-pedidos')
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
            integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }

        </style>
    @endpush
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
            integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            $('#add_producto').submit(e => {
                e.preventDefault();
                let datos = {
                    cantidad: $('#cantidad').val(),
                    producto: $('#buscar').val(),
                }
                $('#buscar').val('')
                $('#cantidad').val('')
                $.ajax({
                    url: "{{ route('pedido.store') }}",
                    method: 'post',
                    data: datos,
                    success: function(data) {
                        if (data == 'add') {
                            Toast.fire({
                                icon: 'success',
                                title: 'Producto Agregado'
                            })
                            Livewire.emit('render')
                            Livewire.emit('render2')
                        }
                    }
                })
            })
            $("body").on("click", ".editar_pro", function(e) {
                e.preventDefault();
                let datos = {
                    cantidad: $(this).parents().parents().children("tr td").find(".btn-group input").val()
                }
                let rowId = $(this).parents().children("input.rowId").val();

                $.ajax({
                    url: "pedido/edit/" + rowId,
                    method: 'post',
                    data: datos,
                    success: function(data) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Producto Actualizado'
                        })
                        Livewire.emit('render2')
                        Livewire.emit('render')
                    }
                })
            })
            $('#pedido').click(function() {
                Swal.fire({
                    title: 'Vas a finalizar el pedido?',
                    text: "Ingresa el valor que paga el cliente!",
                    input: 'number',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continuar',
                    showLoaderOnConfirm: true,
                    preConfirm: (valor) => {
                        return fetch('./pedido/chekout/' + valor, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .then(response => {
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: `Venta finalizada El cambio es : $` + result.value
                        }).then((result) => {
                            if (result.isConfirmed){
                                location.reload();
                            }
                        })
                    }
                })
            })
            $("#buscar").focus()
        </script>
    @endpush
</x-app-layout>
