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
				<budget-modification :transfer="true"></budget-modification>
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
		@if (isset($model))
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
		@endif
		localStorage.aditional_credit_accounts = JSON.stringify(aditional_credit_accounts);

		async function set_accounts_list(specific_action_id, account_id, amount) {
			var to_add = {
				spac_description: '',
				code: '',
				description: '',
				amount: amount || 0,
				budget_account_id: '',
				budget_specific_action_id: ''
			};

			@if (isset($modAcc))
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
			@endif
			return to_add;
		}
	</script>
@stop



