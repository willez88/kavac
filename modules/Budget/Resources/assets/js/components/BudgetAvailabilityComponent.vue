<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-4" id="budgetAvailabilityInitDate">
					<label><strong>Desde:</strong></label>
					<div class="form-group is-required mt-2">
						<label class="control-label"
							>Partida Presupuestaria</label
						>
						<select2
							v-model="initialCode"
							:options="budgetItemsArray"
						></select2>
					</div>
					<div class="form-group is-required mt-3">
						<label class="control-label">Fecha</label>
						<input
							class="form-control input-sm"
							type="date"
							v-model="initialDate"
						/>
					</div>
				</div>
				<div class="col-4" id="budgetAvailabilityEndDate">
					<label><strong>Hasta:</strong></label>
					<div class="form-group is-required mt-2">
						<label class="control-label"
							>Partida Presupuestaria</label
						>
						<select2
							v-model="finalCode"
							:options="budgetItemsArray"
						></select2>
					</div>
					<div class="form-group is-required mt-3">
						<label class="control-label">Fecha</label
						><input
							class="form-control input-sm"
							type="date"
							v-model="finalDate"
						/>
					</div>
				</div>
				<div class="col-4" id="budgetAvailabilityWithoutMovements">
					<div class="form-group">
						<label class="text-center">
							<strong>Quitar cuentas sin movimientos</strong>
						</label>
						<div class="col-12 bootstrap-switch-mini mt-4">
							<div class="form-check">
								<input
									v-model="accountsWithMovements"
									type="checkbox"
									class="form-check-input"
									id="checkbox"
								/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
			<button
				class="btn btn-primary btn-sm"
				data-toggle="tooltip"
				title="Generar Reporte"
				@click="generateReport"
				id="budgetAvailabilityGenerateReport"
			>
				<span>Generar reporte</span>
				<i class="fa fa-print"></i>
			</button>
		</div>
	</div>
</template>
<script>
export default {
	props: {
		budgetItems: {
			type: String,
			default: '[]'
		},
		url: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			initialDate: '',
			finalDate: '',

			initialCode: 0,
			finalCode: 0,

			accountsWithMovements: false,

			budgetItemsArray: JSON.parse(this.budgetItems)
		};
	},
	created() {
		console.log('BudgetAvailabiltyComponent');
	},
	methods: {
		generateReport: function() {
			window.open(
				`${this.url}?initialDate=${this.initialDate}&finalDate=${this.finalDate}&initialCode=${this.initialCode}&finalCode=${this.finalCode}&accountsWithMovements=${this.accountsWithMovements}`
			);
		}
	}
};
</script>
