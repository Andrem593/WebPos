<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Detalle del Pedido</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
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
        <div class="mx-auto p-2 row">
            <div class="col">
                <button id="pedido" type="button" class="btn bg-success w-100"><i class="far fa-money-bill-alt me-1"></i>Pagar Pedido</button>
            </div>
            <div class="col">
                <a href="{{route('pedido.destroyAll')}}" class="btn bg-danger w-100"><i class="fa fa-fw fa-trash me-1"></i>Borrar Todo</a>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
