@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes Institucionales
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Asignacion de bien institucional</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! (!isset($model))?Form::open($header_asset):Form::model($model, $header_asset) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('institution', 'Institución', []) !!}
								{!! Form::select('institution_id', (isset($institutions))?$institutions:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la institución donde será asignado el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('dependencia', 'Unidad Administrativa Receptora', []) !!}
								{!! Form::select('dependencia_id', (isset($dependencia))?$dependencia:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la unidad administrativa responsable del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('staff', 'Trabajador Activo', []) !!}
								{!! Form::select('staff_id', (isset($payroll_staffs))?$payroll_staffs:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el trabajador activo responsable del bien'
								]) !!}

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
