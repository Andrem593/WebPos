<x-app-layout>
    @section('title', 'Carga de Compras')
        <x-slot name="header">
            CARGA MASIVA DE COMPRAS
        </x-slot>

        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        {{ __('Carga de compras') }}
                    </span>
                </div>
            </div>
            <form action="{{ route('compras.saveExcel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                @section('plugins.BsCustomFileInput', true)

                    <x-adminlte-input-file name="excel" class="" igroup-size="sm" label="Cargar archivo (.xls, .xlsx)"
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
                    <button type="submit" class="btn btn-primary">Cargar Compras</button>
                </div>
            </form>

        </div>
    </x-app-layout>
