<template>
	<div>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="content" slot-scope="props" class="text-center">
				<table class="table">
					<tbody>
						<tr>
							<h6 class="text-left" style="display:inline; float: left; margin:0.5rem;"><strong>Referencia:</strong> {{ props.row.reference }}</h6>
							
							<h6 class="text-center" style="display:inline;"><strong>Asiento Contable del {{ 				props.row.from_date.split('-')[2]+'-'+
								props.row.from_date.split('-')[1]+'-'+
								props.row.from_date.split('-')[0] }}</strong></h6>

							<button class="btn btn-danger btn-sm btn-custom"
									style="display:inline;float: right; margin: 0.6rem;"
									title="Eliminar Registro"
									data-toggle="tooltip"
									@click="deleteRecord(props.index, '/accounting/seating')"
									v-if="show=='unapproved'">
									<i class="fa fa-close" style="text-align: center;"></i>
							</button>
							<button class="btn btn-warning btn-sm btn-custom"
									style="display:inline;float: right; margin: 0.6rem;"
									title="Modificar registro"
									data-toggle="tooltip"
									@click="editForm(props.row.id)"
									v-if="show=='unapproved'">
									<i class="fa fa-edit" style="text-align: center;"></i>
							</button>
							<button class="btn btn-success btn-sm btn-custom"
									style="display:inline;float: right; margin: 0.6rem;"
									title="Aprobar Registro"
									data-toggle="tooltip"
									@click="approve(props.index, url)"
									v-if="show=='unapproved'">
									Aprobar <i class="fa fa-check" style="text-align: center;"></i>
							</button>
							<a class="btn btn-primary btn-sm btn-custom"
									style="display:inline;float: right; margin: 0.6rem;"
									:href="url+'/pdf/'+props.row.id"
									title="Imprimir Registro"
									data-toggle="tooltip"
									target="_blank"
									v-if="show=='approved'">
									<i class="fa fa-print" style="text-align: center;"></i>
							</a>
						</tr>
						<tr>
							<td class="text-left">
								<h6><strong>Concepto: </strong> {{ props.row.concept }}</h6>
							</td>
						</tr>
						<tr>
							<td class="text-left">
								<h6><strong>Observaciones: </strong> {{ props.row.observations }}</h6>
							</td>
						</tr>
						<tr>
							<td>
								<h6 class="text-center" style="display:inline;"><strong>Asiento contable</strong></h6>
								<button class="btn btn-secondary btn-sm btn-custom"
										:id="'i-'+props.row.id+'-show'"
										style="float: right; display:none;"
										title="Ocultar detalles de cuentas" data-toggle="tooltip"
										@click="displayDetails(props.row.id)">
										<i class="now-ui-icons arrows-1_minimal-up"></i>
								</button>
								<button class="btn btn-secondary btn-sm btn-custom"
										:id="'i-'+props.row.id+'-none'"
										style="float: right;"
										title="Mostrar detalles de cuentas" data-toggle="tooltip"
										@click="displayDetails(props.row.id)">
										<i class="now-ui-icons arrows-1_minimal-down"></i>
								</button>
							</td>
						</tr>
						<tr>
							<table class="table">
								<thead>
									<tr>
										<td><h6><strong>CÓDIGO</strong></h6></td>
										<td><h6><strong>DENOMINACIÓN</strong></h6></td>
										<td><h6><strong>DEBE</strong></h6></td>
										<td><h6><strong>HABER</strong></h6></td>
									</tr>
								</thead>
								<tbody>
									<tr v-for="record in props.row.accounting_accounts" :name="'details_'+props.row.id" style="display:none;">
										<td>
											<h6>
												{{
													record.account.group +'.'+
													record.account.subgroup +'.'+
													record.account.item +'.'+
													record.account.generic +'.'+
													record.account.specific +'.'+
													record.account.subspecific
												}}
											</h6>
										</td>
										<td class="text-left">
											<h6>{{ record.account.denomination }}</h6>
										</td>
										<td>
											<h6><span>{{ currency.symbol }}</span> {{ parseFloat(record.debit).toFixed(currency.decimal_places) }}</h6>
										</td>
										<td>
											<h6><span>{{ currency.symbol }}</span> {{ parseFloat(record.assets).toFixed(currency.decimal_places) }}</h6>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<h6><strong>Total Debe / Haber </strong></h6>
										</td>
										<td>
											<h6>
												<span>{{ currency.symbol }}</span>
												<strong>{{ parseFloat(props.row.tot_debit).toFixed(currency.decimal_places) }}</strong>
											</h6>
										</td>
										<td>
											<h6>
												<span>{{ currency.symbol }}</span>
												<strong>{{ parseFloat(props.row.tot_assets).toFixed(currency.decimal_places) }}</strong>
											</h6>
										</td>
									</tr>
								</tbody>
							</table>	
						</tr>
					</tbody>
					<br><br>
				</table>
			</div>
		</v-client-table>
	</div>
</template>
<script>
	export default{
		props:['seating','show','currency'],
		data(){
			return {
				minimized:true,
				records: [],
				url: 'http://'+window.location.host+'/accounting/seating', 
				columns: ['content'],
			}
		},
		created(){
			this.table_options.headings = {
				'content': 'ASIENTOS CONTABLES',
			};
			this.records = this.seating;
			EventBus.$on('reload:listing',(data)=>{
				this.records = data;
			})
		},
	};

</script>
