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
                @php
                    $i = 0;
                @endphp
                @foreach (Cart::content() as $item)
                    <tr>
                        <td>{{ ++$i }}</td>

                        <td>{{ $item->options->codigo_barras }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->qty, 2) }}</td>
                        <td>
                            <form action="{{ route('pedido.destroy', $item->rowId) }}"
                                method="POST">                                
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-gradient-danger"><i
                                        class="fa fa-fw fa-trash"></i> Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
