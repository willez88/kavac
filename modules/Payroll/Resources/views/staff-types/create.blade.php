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
	Tipo de Personal
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Registrar Tipo de Personal</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! Form::open($header_staff_type) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
								{!! Form::label('name', 'Nombre', []) !!}
								{!! Form::text('name','',
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el nombre de tipo de personal'
									]
								) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} is-required">
								{!! Form::label('description', 'Descripción', []) !!}
								{!! Form::text('description','',
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique la descripción del tipo de personal'
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
