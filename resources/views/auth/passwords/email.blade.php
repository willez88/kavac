@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'password.email', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <div class="header header-primary text-center">
            <div class="logo-container">
                @include('layouts.logo-images', ['logo_mini' => true, 'logo_name' => true])
            </div>
            <h6>Reiniciar Contraseña</h6>
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
                        'class' => 'form-control', 'placeholder' => 'Correo', 'required' => 'required',
                        'data-toggle' => 'tooltip', 'title' => 'Indique el correo a donde enviar el enlace de modificación'
                    ]) !!}
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="footer text-center">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip" title="Presione el botón para regresar"
                                onclick="location.href='/'" type="button">
                            Cancelar
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip"
                                title="Presione el botón para enviar el enlace de modificación">
                            Enviar enlace
                        </button>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
