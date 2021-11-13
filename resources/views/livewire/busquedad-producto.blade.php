<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Buscar Producto</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#caja"><i
                    class="fas fa-cash-register"></i>
            </button>
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
                            placeholder="Escribe el nombre del producto o codigo de barras" {{$valorInicio == 0 ? 'disabled': ''}}>
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
    <div class="modal lg" id="caja" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Arqueo de caja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($valorInicio == 0)                        
                        <div class="mb-3">
                            <label for="valor_inicial" class="form-label">Ingrese Valor con el que inicia la caja:</label>
                            <input type="text" class="form-control" id="valor_inicio" wire:model.defer='valorInicio'>
                        </div>
                    @else
                        <div class="form-group">
                            <strong>Valor de Inicio de caja: </strong>
                            ${{ $valorInicio }}
                        </div>
                        <div class="form-group">
                            <strong>Ventas del Día: </strong>
                            ${{ $ventas }}
                        </div>
                        <div class="form-group">
                            <strong>Total en caja: </strong>
                            ${{ $valorInicio + $ventas }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    @if ($valorInicio == 0)                        
                        <button type="button" id="detalle_venta" class="btn btn-primary" wire:click="inicio_caja">Guardar</button>
                    @else
                        <button type="button" id="detalle_venta" class="btn btn-primary" wire:click="cerrar_caja" >Cerrar Caja</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('#detalle_venta').click(function(){
                $('#caja .close').click();
            })
        </script>
    @endpush
</div>
