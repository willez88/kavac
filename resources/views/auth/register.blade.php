@extends('layouts.app')

@section('maproute-icon')
    <i class="fa fa-user"></i>
@stop

@section('maproute-icon-mini')
    <i class="fa fa-user"></i>
@stop

@section('maproute-actual')
    Usuarios
@stop

@section('maproute-title')
    Usuarios
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">Gestión de usuario</h6>
            <div class="card-btns">
                @include('buttons.previous', ['route' => url()->previous()])
                @include('buttons.minimize')
            </div>
        </div>
        @if (!isset($model)) {!! Form::open($header) !!} @else {!! Form::model($model, $header) !!} @endif
            {!! Form::token() !!}
            <div class="card-body">
                @include('layouts.form-errors')
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('staff', 'Empleado', []) !!}
                            {!! Form::select('staff', (isset($persons))?$persons:[], null, [
                                    'class' => 'form-control select2',
                                    'onchange' => '' // En el evento onchange agregar instrucción para obtener datos de la persona configurada en expediente de nómina (Ej. correo)
                                ]
                            ) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('email', 'Correo electrónico', []) !!}
                            {!! Form::text('email', (isset($model))?$model->email:old('email'), [
                                'class' => 'form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'title' => 'Indique el correo electrónico al cual envíar los datos de acceso'
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::label('username', 'Usuario', []) !!}
                            {!! Form::text('username', (isset($model))?$model->username:old('username'), [
                                'class' => 'form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'title' => 'Indique el nombre de usuario'
                            ]) !!}
                        </div>
                    </div>
                </div>
                @include('auth.roles-permissions', ['user' => $model ?? null])
            </div>
            <div class="card-footer text-right">
                @include('buttons.form-display')
                @include('layouts.form-buttons')
            </div>
        {!! Form::close() !!}
    </div>
{{--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
