@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Formatos de Códigos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => 'budget.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Formulación</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('formulations_code', 'Código de Formulación', []) !!}
									{!! Form::text('formulations_code', ($fCode) ? $fCode->format_code : old('formulations_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de la formulación de presupuesto',
										'placeholder' => 'Ej. XXX-0000000000-YYYY', 
										'readonly' => ($fCode) ? true : false
									]) !!}
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-12">
								<h6>Ejecución</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('commitments_code', 'Código de Compromiso', []) !!}
									{!! Form::text('commitments_code', ($cCode) ? $cCode->format_code : old('commitments_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del compromiso',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($cCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('caused_code', 'Código de Causado', []) !!}
									{!! Form::text('caused_code', ($caCode) ? $caCode->format_code : old('caused_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del causado',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($caCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('payed_code', 'Código de Pagado', []) !!}
									{!! Form::text('payed_code', ($pCode) ? $pCode->format_code : old('payed_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del pagado',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($pCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('transfers_code', 'Código de Traspaso', []) !!}
									{!! Form::text('transfers_code', ($tCode) ? $tCode->format_code : old('transfers_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del traspaso',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($tCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('reductions_code', 'Código de Reducción', []) !!}
									{!! Form::text('reductions_code', ($rCode) ? $rCode->format_code : old('reductions_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de reducciones',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($rCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('credits_code', 'Código de Crédito Adicional', []) !!}
									{!! Form::text('credits_code', ($crCode) ? $crCode->format_code : old('credits_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de créditos adicionales',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($crCode) ? true : false
									]) !!}
								</div>
							</div>
						</div>
						@include('layouts.help-text', ['codeSetting' => true])
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proyectos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.projects.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-projects-list route_list='{{ url('budget/projects/vue-list') }}' 
										  route_delete="{{ url('budget/projects') }}" 
										  route_edit="{{ url('budget/projects/{id}/edit') }}">
					</budget-projects-list>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acciones Centralizadas</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.centralized-actions.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-centralized-actions-list route_list='{{ url('budget/centralized-actions/vue-list') }}' 
										  route_delete="{{ url('budget/centralized-actions') }}" 
										  route_edit="{{ url('budget/centralized-actions/{id}/edit') }}">
					</budget-centralized-actions-list>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acciones Específicas</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.specific-actions.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-specific-actions-list route_list='{{ url('budget/specific-actions/vue-list') }}' 
										  route_delete="{{ url('budget/specific-actions') }}" 
										  route_edit="{{ url('budget/specific-actions/{id}/edit') }}">
					</budget-specific-actions-list>
				</div>
			</div>
		</div>
	</div>
@stop