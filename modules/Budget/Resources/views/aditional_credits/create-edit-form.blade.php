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
									{!! Form::date('approved_at', (isset($model) && !old('approved_at')) ? $model->approved_at : old('approved_at'), [
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

@section('extra-js')
	@parent
	<script>
		var aditional_credit_accounts = [];
		var to_add = {
			spac_description: '',
			code: '',
			description: '',
			amount: 0,
			budget_account_id: '',
			budget_specific_action_id: ''
		};
		@foreach ($model->budget_modificacion_accounts()->get() as $modification_account)
			@php
				$modAcc = $modification_account->with(['budget_sub_specific_formulation' => function($query) {
					return $query->with(['specific_action' => function($q) {
						return $q->with('specificable');
					}]);
				}])->first();
			@endphp
			
			to_add = set_accounts_list({{ $modAcc->budget_sub_specific_formulation->budget_specific_action_id }}, {{ $modAcc->budget_account_id }});

			aditional_credit_accounts.push(to_add);
		@endforeach
		localStorage.aditional_credit_accounts = JSON.stringify(aditional_credit_accounts);
		console.log(localStorage.aditional_credit_accounts)

		async function set_accounts_list(specific_action_id, account_id, amount) {
			var to_add = {
				spac_description: '',
				code: '',
				description: '',
				amount: amount || 0,
				budget_account_id: '',
				budget_specific_action_id: ''
			};
			/** Obtiene datos de la acción específica seleccionada */
			await axios.get('/budget/detail-specific-actions/' + specific_action_id).then(response => {
				if (response.data.result) {
					let record = response.data.record;
					to_add.spac_description = record.specificable.code + " - " + record.code + " | " + record.name;
					to_add.budget_account_id = {{ $modAcc->budget_account_id }};
					to_add.budget_specific_action_id = {{ $modAcc->budget_sub_specific_formulation->budget_specific_action_id }};
					/** Obtiene datos de la cuenta presupuestaria */
					axios.get('/budget/detail-accounts/' + account_id).then(response => {
						if (response.data.result) {
							let record = response.data.record;
							to_add.code = `${record.group}.${record.item}.${record.generic}.${record.specific}.${record.subspecific}`;
							to_add.description = response.data.record.denomination;
						}
					}).catch(error => {
						console.log(error);
					});
				}
			}).catch(error => {
				console.log(error);
			});
			return to_add;
		}
	</script>
@stop



