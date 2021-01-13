@extends('layouts.app')

@section('maproute-icon')
    <i class="fa fa-user"></i>
@stop

@section('maproute-icon-mini')
    <i class="fa fa-user"></i>
@stop

@section('maproute-actual')
    {{ __('Usuarios') }}
@stop

@section('maproute-title')
    {{ __('Usuarios') }}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">{{ __('Gestión de usuario') }}</h6>
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
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('staff', __('Empleado'), []) !!}
                            {!! Form::select('staff', (isset($persons))?$persons:[], null, [
                                    'class' => 'form-control select2', 'onchange' => 'hasStaff()',
                                    'id' => 'staff'
                                ]
                            ) !!}
                        </div>
                    </div>
                    <div class="col-6 staff_name">
                        <div class="form-group is-required">
                            {!! Form::label('first_name', __('Nombre'), ['id' => 'first_name_label']) !!}
                            {!! Form::text('first_name', (isset($model))?$model->profile->first_name:old('first_name'), [
                                'class' => 'form-control input-sm', 'id' => 'first_name', 'data-toggle' => 'tooltip',
                                'title' => __('Indique el Nombre completo de la persona')
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group is-required">
                            {!! Form::label('email', __('Correo electrónico'), []) !!}
                            {!! Form::text('email', (isset($model))?$model->email:old('email'), [
                                'class' => 'form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'title' => __('Indique el correo electrónico al cual envíar los datos de acceso')
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group is-required">
                            {!! Form::label('username', __('Usuario'), []) !!}
                            {!! Form::text('username', (isset($model))?$model->username:old('username'), [
                                'class' => 'form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'title' => __('Indique el nombre de usuario')
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
@endsection

@section('extra-js')
    <script>
        /**
         * Muestra u oculta el campo de nombre si no se ha seleccionado un empleado
         *
         * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         */
        var hasStaff = () => {
            $(".staff_name").show();
            if ($('#staff').val() !== "") {
                $(".staff_name").hide();
            }
        }
    </script>
@endsection
