<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('codigo_barras') }}
                    {{ Form::text('codigo_barras', $producto->codigo_barras, ['class' => 'form-control' . ($errors->has('codigo_barras') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Barras']) }}
                    {!! $errors->first('codigo_barras', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $producto->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('descripcion') }}
                    {{ Form::text('descripcion', $producto->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Categoria del producto') }}
                    <input type="text" name="nombre_categoria" class="form-control" placeholder="Ingrese el nombre de la categoria">
                    {!! $errors->first('categoria', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Nombre del Proveedor') }}
                    <input type="text" name="nombre_proveedor" class="form-control" placeholder="Ingrese el nombre del Proveedor">
                    {!! $errors->first('proveedor', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Unidad de Medida') }}
                    <select name="unidad_medida" class="form-control" id="">
                        <option value="unidad">ud-Unidad</option>
                        <option value="gramos">gr-Gramos</option>
                        <option value="kilogramos">kg-Kilogramos</option>
                        <option value="centimetros">cm-Centimetros</option>
                        <option value="metros">m-Metros</option>
                        <option value="mililitros">ml-Mililitros</option>
                        <option value="litros">l-Litros</option>
                    </select>
                    {!! $errors->first('unidad_medida', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('medida') }}
                    {{ Form::text('medida', $producto->medida, ['class' => 'form-control' . ($errors->has('medida') ? ' is-invalid' : ''), 'placeholder' => 'medida']) }}
                    {!! $errors->first('medida', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Costo del Producto') }}
                    {{ Form::text('costo_proveedor', $producto->costo_proveedor, ['class' => 'form-control' . ($errors->has('costo_proveedor') ? ' is-invalid' : ''), 'placeholder' => 'Costo del producto']) }}
                    {!! $errors->first('costo_proveedor', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('cantidad') }}
                    {{ Form::text('cantidad', $producto->cantidad, ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
                    {!! $errors->first('cantidad', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('stock') }}
                    {{ Form::text('stock', $producto->stock, ['class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''), 'placeholder' => 'Stock']) }}
                    {!! $errors->first('stock', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('precio') }}
                    {{ Form::text('precio', $producto->precio, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
                    {!! $errors->first('precio', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">GUARDAR</button>
    </div>
</div>
