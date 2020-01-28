@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'password.email', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <div class="header header-primary text-center">
            <div class="logo-container">
                @include('layouts.logo-images', ['logo_mini' => true, 'logo_name' => true])
            </div>
            <h6>{{ __('Reiniciar Contraseña') }}</h6>
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
                        'class' => 'form-control', 'placeholder' => __('Correo'), 'required' => 'required',
                        'data-toggle' => 'tooltip',
                        'title' => __('Indique el correo a donde enviar el enlace de modificación')
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
                        <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip" type="button"
                                title="{{ __('Presione el botón para regresar') }}" onclick="location.href='/'">
                            {{ __('Cancelar') }}
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip"
                                title="{{ __('Presione el botón para enviar el enlace de modificación') }}">
                            {{ __('Enviar enlace') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
