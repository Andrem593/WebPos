<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ $user->name ?? 'Usuario : '.$user->name }}
        </h2>
    </x-slot>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Ver Usuario</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('user.index') }}"> Regresar</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre Usuario:</strong>
                            {{ $user->name }}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="form-group">
                            <strong>Rol de Usuario:</strong>
                            
                        </div>
                        <div class="form-group">
                            <strong>Fecha de creacion:</strong>
                            {{ $user->created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
