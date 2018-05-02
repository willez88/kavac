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
	Catálogo de Cuentas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Cuenta Presupuestaria</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Cuenta</label>
									{!! Form::select('parent_id', [], null, ['class' => 'select2']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Código</label>
									<div class="row inline-inputs">
										<div class="col-1">
											{!! Form::text('group', old('group'), [
												'class' => 'form-control', 'placeholder' => '0', 'data-toggle' => 'tooltip',
												'title' => 'Grupo al que pertenece la cuenta', 'maxlength' => '1'
											]) !!}
										</div>
										<div class="col-1">.</div>
										<div class="col-1">
											{!! Form::text('item', old('item'), [
												'class' => 'form-control', 'placeholder' => '00', 'data-toggle' => 'tooltip',
												'title' => 'Ítem al que pertenece la cuenta', 'maxlength' => '2'
											]) !!}
										</div>
										<div class="col-1">.</div>
										<div class="col-1">
											{!! Form::text('generic', old('generic'), [
												'class' => 'form-control', 'placeholder' => '00', 'data-toggle' => 'tooltip',
												'title' => 'Genérica a la que pertenece la cuenta', 'maxlength' => '2'
											]) !!}
										</div>
										<div class="col-1">.</div>
										<div class="col-1">
											{!! Form::text('specific', old('specific'), [
												'class' => 'form-control', 'placeholder' => '00', 'data-toggle' => 'tooltip',
												'title' => 'Específica a la que pertenece la cuenta', 'maxlength' => '2'
											]) !!}
										</div>
										<div class="col-1">.</div>
										<div class="col-1">
											{!! Form::text('subespecific', old('subespecific'), [
												'class' => 'form-control', 'placeholder' => '00', 'data-toggle' => 'tooltip',
												'title' => 'Subespecífica a la que pertenece la cuenta', 'maxlength' => '2'
											]) !!}
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Denominación</label>
									{!! Form::text('denomination', old('denomination'), [
										'class' => 'form-control', 'placeholder' => 'descripción de la cuenta',
										'title' => 'Denominacón o concepto de la cuenta',  'data-toggle' => 'tooltip',
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="row">
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">Recurso</label>
											<div class="col-12">
												{!! Form::radio('account_type', 'resource', (isset($model) && $model->resource), [
													'id' => 'account_type', 'class' => 'form-control bootstrap-switch',
													'data-on-label' => 'SI', 'data-off-label' => 'NO'
												]) !!}
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">Egreso</label>
											<div class="col-12">
												{!! Form::radio('account_type', 'egress', (isset($model) && $model->egress), [
													'id' => 'account_type', 'class' => 'form-control bootstrap-switch',
													'data-on-label' => 'SI', 'data-off-label' => 'NO'
												]) !!}
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">Original</label>
											<div class="col-12">
												{!! Form::checkbox('original', true, (isset($model) && $model->original), [
													'id' => 'original', 'class' => 'form-control bootstrap-switch',
													'data-on-label' => 'SI', 'data-off-label' => 'NO'
												]) !!}
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">Activa</label>
											<div class="col-12">
												{!! Form::checkbox('active', true, (isset($model) && $model->active), [
													'id' => 'active', 'class' => 'form-control bootstrap-switch',
													'data-on-label' => 'SI', 'data-off-label' => 'NO'
												]) !!}
											</div>
										</div>
									</div>
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