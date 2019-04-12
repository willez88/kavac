@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Grados de Instrucción
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar Grados de Instrucción</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($instruction_degree))?Form::open($header):Form::model($instruction_degree, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
						    <div class="col-md-6">
						        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('name', 'Nombre', []) !!}
						            {!! Form::text('name',(isset($instruction_degree))?$instruction_degree->name:old('name'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el nombre del grado de instrucción'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-6">
						        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
						            {!! Form::label('description', 'Descripción', []) !!}
						            {!! Form::text('description',(isset($instruction_degree))?$instruction_degree->description:old('description'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la descripción del grado de instrucción'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop
