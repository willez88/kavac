@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Créditos Adicionales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Crédito Adicional</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-md-2">
								<div class="form-group is-required">
									{!! Form::label('approved_at', 'Fecha de creación', [
										'class' => 'control-label'
									]) !!}
									{!! Form::date('approved_at', old('approved_at'), [
										'class' => 'form-control input-sm', 'placeholder' => 'dd/mm/YY',
										'data-toggle' => 'tooltip', 'id' => 'approved_at',
										'title' => 'Fecha en la que se otorgó el crédito adicional'
									]) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<div class="form-group is-required">
									{!! Form::label('institution_id', 'Institución', ['class' => 'control-label']) !!}
									{!! Form::select('institution_id', $institutions, null, [
										'class' => 'select2', 'data-toggle' => 'tooltip',
										'title' => 'Seleccione una institución'
									]) !!}
								</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									{!! Form::label('document', 'Documento', ['class' => 'control-label']) !!}
									{!! Form::text('document', old('document'), [
										'class' => 'form-control input-sm', 'placeholder' => 'Nro. Documento',
										'data-toggle' => 'tooltip', 
										'title' => 'Número del documento, decreto o misiva que avala ' . 
												   'el crédito adicional'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group is-required">
									{!! Form::label('description', 'Descripción', [
										'class' => 'control-label'
									]) !!}
									{!! Form::text('description', old('description'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip', 
										'placeholder' => 'Descripción / Detalles',
										'title' => 'Descripción o detalle del crédito adicional'
									]) !!}
								</div>
							</div>
						</div>
						<budget-aditional-credit-add/>
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop