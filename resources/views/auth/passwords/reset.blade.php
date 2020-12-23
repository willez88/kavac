@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'password.request', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <p class="login-img text-center pt-3">
            @include('layouts.logo-images', ['logo_mini' => true])
        </p>
        <h2 class="h6 text-light text-center pb-3">{{ __('Reiniciar Contraseña') }}</h2>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon text-light">
                    <i class="now-ui-icons ui-1_email-85"></i>
                </span>
                {!! Form::email('email', old('email'), [
                    'class' => 'form-control', 'placeholder' => __('Correo'), 'required' => 'required',
                    'id' => 'email', 'data-toggle' => 'tooltip', 'title' => __('Indique el correo electrónico')
                ]) !!}
            </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon text-light">
                    <i class="now-ui-icons ui-1_lock-circle-open text-light"></i>
                </span>
                {!! Form::password('password', old('password'), [
                    'class' => 'form-control', 'required' => 'required', 'id' => 'password', 'data-toggle' => 'tooltip',
                    'title' => __('Indique su nueva contraseña')
                ]) !!}
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon text-light">
                    <i class="now-ui-icons ui-1_lock-circle-open text-light"></i>
                </span>
                {!! Form::password('password_confirmation', old('password_confirmation'), [
                    'class' => 'form-control', 'required' => 'required', 'id' => 'password-confirm',
                    'data-toggle' => 'tooltip', 'title' => __('Confirme su nueva contraseña')
                ]) !!}
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        <div class="footer text-center">
            <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip"
                    title="{{ __('Presione el botón para modificar la contraseña') }}">
                {{ __('Modificar') }}
            </button>
        </div>
    {!! Form::close() !!}
@endsection
