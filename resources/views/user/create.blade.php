<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default w-50 mx-auto">
                    <div class="card-header">
                        <span class="card-title">Crear Usuario</span>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('user.index') }}"> Regresar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('user.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>