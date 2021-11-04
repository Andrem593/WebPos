<div class="box box-info padding-1">
    <div class="box-body">
        <div class="mb-3">
            <x-jet-label value="{{ __('Name') }}" />

            {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre del usuario']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <div class="mb-3">
            <x-jet-label value="{{ __('Email') }}" />

            {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'email del usuario']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <div class="mb-3">
            <x-jet-label value="{{ __('Password') }}" />

            <x-jet-input class="{{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
                required autocomplete="new-password" />
            <x-jet-input-error for="password"></x-jet-input-error>
        </div>

        <div class="mb-3">
            <x-jet-label value="{{ __('Confirm Password') }}" />

            <x-jet-input class="form-control" type="password" name="password_confirmation" required
                autocomplete="new-password" />
        </div>

        <div class="mb-0">
            <div class="d-flex justify-content-start align-items-baseline">

                <x-jet-button>
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </div>
    </div>
</div>
