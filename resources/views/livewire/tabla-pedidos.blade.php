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
        <tbody class="bg-light">
            @if (Cart::count() > 0)
                @php
                    $i = 0;
                @endphp
                @foreach (Cart::content() as $item)
                    <tr>
                        <td>{{ ++$i }}</td>

                        <td>{{ $item->options->codigo_barras }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                <button type="button" class="btn btn-dark"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                                <input type="number" min="1" class="p-0 text-center cantidad_actualizar" value="{{ $item->qty }}"
                                    style="width: 30px">
                                <button type="button" class="btn btn-dark"
                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                            </div>
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->qty, 2) }}</td>
                        <td>
                            <form action="{{ route('pedido.destroy', $item->rowId) }}" method="POST">
                                <a class="editar_pro btn bg-primary"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                <input class="rowId" type="hidden" value="{{$item->rowId}}"> 
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-danger"><i class="fa fa-fw fa-trash"></i>
                                    Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
