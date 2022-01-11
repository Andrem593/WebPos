<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('Numero de Factura') }}
            {{ Form::text('numero_factura', $compra->numero_factura, ['class' => 'form-control' . ($errors->has('numero_factura') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el número de la factura de compra']) }}
            {!! $errors->first('numero_factura', '<p class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Escoja el Proveedor') }}
            <select name="id_proveedor" id="proveedor" class="form-select">
                <option>SELECCIONE</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
            @error('id_proveedor')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('Escoja el Producto') }}
            <div class="input-group">
                <input type="search" id="buscar" name="nombre_producto" class="form-control" value="{{!empty($producto->nombre)  ? $producto->nombre.' | '.$producto->descripcion :  ''}}"
                    placeholder="Escribe el nombre del producto o codigo de barras">
                <div class="input-group-append">
                    <a class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
            @error('nombre_producto')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            {{ Form::label('Cantidad') }}
            {{ Form::number('cantidad', $compra->cantidad, ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese la cantidad comprada del producto']) }}
            {!! $errors->first('cantidad', '<p class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Costo Unitario') }}
            {{ Form::text('costo', $compra->costo, ['class' => 'form-control' . ($errors->has('costo') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el costo unitario del producto']) }}
            {!! $errors->first('costo', '<p class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Total de la factura') }}
            {{ Form::text('total_factura', $compra->total_factura, ['class' => 'form-control' . ($errors->has('total_factura') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el total de la factura de compra']) }}
            {!! $errors->first('total_factura', '<p class="invalid-feedback">:message</p>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-dark w-100">Guardar</button>
    </div>
</div>
@push('css')
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
                    url: "{{ route('search.productos_proveedor') }}",
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
