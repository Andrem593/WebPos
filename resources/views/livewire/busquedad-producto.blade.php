<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Buscar Producto</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <div class="card-body">
        <form id="add_producto" role="form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <label>Busquedad</label>
                    <div class="input-group">
                        <input type="search" id="buscar" name="producto" class="form-control form-control-lg"
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
