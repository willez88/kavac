@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'password.email', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <div class="header header-primary text-center">
            Reiniciar Contraseña
        </div>
        <div class="content">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="form-group">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons ui-1_email-85"></i>
                    </span>
                    {!! Form::email('email', old('email'), [
                        'class' => 'form-control', 'placeholder' => 'Correo', 'required' => 'required'
                    ]) !!}
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="footer text-center">
                <button class="btn btn-primary btn-round btn-lg btn-block">
                    Enviar enlace de reinicio
                </button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
