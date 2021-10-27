<x-app-layout>
    @section('title', 'Carga Producto')
        <x-slot name="header">
            CARGA DE PRODUCTOS
        </x-slot>

        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        {{ __('Producto') }}
                    </span>

                    <div class="float-right">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary btn-sm float-right"
                            data-placement="left">
                            {{ __('Regresar') }}
                        </a>
                    </div>
                </div>
            </div>
            <form action="{{ route('producto.saveExcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                @section('plugins.BsCustomFileInput', true)

                    <x-adminlte-input-file name="excel" class="" igroup-size="sm" label="Carga archivo (.xls, .xlsx)"
                        legend="Seleccionar" placeholder="Escoger un archivo .xls o .xlsx"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                        <x-slot name="prependSlot">
                            <div class="input-group-text btn-primary">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-input-file>
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Cargar productos</button>
                </div>
            </form>

        </div>
    </x-app-layout>
