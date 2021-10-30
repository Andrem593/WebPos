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
        <link rel="stylesheet" href="/css/botonesDataTable.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
            integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                $.ajax({
                    url: "{{ route('pedido.store') }}",
                    method: 'post',
                    data: datos,
                    success: function(data) {
                        $('#buscar').val('')
                        $('#cantidad').val('')
                        if(data == 'add'){
                            Livewire.emit('render')
                        }
                    }
                })
            })

        </script>
    @endpush
</x-app-layout>
