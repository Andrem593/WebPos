<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ $proveedore->name ?? 'Ver Proveedor' }}
        </h2>
    </x-slot>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Datos del Proveedor</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('proveedores.index') }}"> Regresar</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Ruc:</strong>
                            {{ $proveedore->ruc }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $proveedore->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Teléfono:</strong>
                            {{ $proveedore->telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ $proveedore->correo }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            @php
                                if ($proveedore->estado == 'A') {
                                    echo '<span class="badge bg-success">ACTIVO</span>';
                                } else {
                                    echo '<span class="badge bg-danger">INACTIVO</span>';
                                }
                            @endphp
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
