@extends('budget::layouts.master')

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
					<h6 class="card-title">
						Formatos de Códigos
						@include('buttons.help', [
							'helpId' => 'BudgetCodeSetting',
							'helpSteps' => [
								[
									'element' => '#helpCodeSetting',
									'intro' => 'Esta sección permite establecer el formato a utilizar por los códigos en cada uno de los registros descritos, para comenzar en su implementación tenga especial cuidado en seguir las instrucciones en cuanto al formato que acepta esta configuración'
								],
								[
									'element' => '#helpCodeFormulations',
									'intro' => 'La configuración de este código permite identificar los registros de formulaciones mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodeCommitments',
									'intro' => 'La configuración de este código permite identificar los registros de compromisos presupuestarios mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodeCaused',
									'intro' => 'La configuración de este código permite identificar los registros de compromisos presupuestarios causados mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodePayed',
									'intro' => 'La configuración de este código permite identificar los registros de compromisos presupuestarios pagados mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodeTransfers',
									'intro' => 'La configuración de este código permite identificar los registros de traspasos presupuestarios mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodeReductions',
									'intro' => 'La configuración de este código permite identificar los registros de reducciones presupuestarios mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								],
								[
									'element' => '#helpCodeCredits',
									'intro' => 'La configuración de este código permite identificar los registros de créditos adicionales mediante un formato único, si no se establece esta configuración el sistema generará un código numérico consecutivo'
								]
							]
						])
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => 'budget.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body" id="helpCodeSetting">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Formulación</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4" id="helpCodeFormulations">
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
							<div class="col-md-4" id="helpCodeCommitments">
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
							<div class="col-md-4" id="helpCodeCaused">
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
							<div class="col-md-4" id="helpCodePayed">
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
							<div class="col-md-4" id="helpCodeTransfers">
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
							<div class="col-md-4" id="helpCodeReductions">
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
							<div class="col-md-4" id="helpCodeCredits">
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
					<h6 class="card-title">
						Proyectos
						@include('buttons.help')
					</h6>
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
					<h6 class="card-title">
						Acciones Centralizadas
						@include('buttons.help')
					</h6>
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
					<h6 class="card-title">
						Acciones Específicas
						@include('buttons.help')
					</h6>
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
