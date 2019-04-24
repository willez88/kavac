<template>
	<div>
		<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="content" slot-scope="props" class="text-center">
					<table class="table">
						<tbody>
							<tr>
								<h5 class="text-left" style="display:inline; float: left; margin:0.5rem;"><strong>Referencia:</strong> {{ props.row.reference }}</h5>
								
								<h5 class="text-center" style="display:inline;"><strong>Asiento del {{ 		props.row.from_date.split('-')[2]+'-'+
									props.row.from_date.split('-')[1]+'-'+
									props.row.from_date.split('-')[0] }}</strong></h5>
								
								<button class="btn btn-danger btn-icon btn-round"
										style="display:inline;float: right; margin: 0.5rem;"
										@click="deleteRecord(props.index, '/accounting/seating')"
										v-if="show=='unapproved'">
										<i class="fa fa-close" style="text-align: center;"></i>
								</button>
								<button class="btn btn-warning btn-icon btn-round"
										style="display:inline;float: right; margin: 0.5rem;"
										@click="editForm(props.row.id)"
										v-if="show=='unapproved'">
										<i class="fa fa-edit" style="text-align: center;"></i>
								</button>
								<button class="btn btn-success btn-icon btn-round"
										style="display:inline;float: right; margin: 0.5rem;"
										@click="approve(props.index)"
										v-if="show=='unapproved'">
										<i class="fa fa-check" style="text-align: center;"></i>
								</button>
								<button class="btn btn-info btn-icon btn-round"
										style="display:inline;float: right; margin: 0.5rem;"
										@click="print(props.row.id)"
										v-if="show=='approved'">
										<i class="fa fa-print" style="text-align: center;"></i>
								</button>
							</tr>
							<tr>
								<td class="text-left">
									<h5><strong>Concepto: </strong> {{ props.row.concept }}</h5>
								</td>
							</tr>
							<tr>
								<td class="text-left">
									<h5><strong>Observaciones: </strong> {{ props.row.observations }}</h5>
								</td>
							</tr>
							<tr>
								<td class="text-center">
									<h5><strong>Asiento contable</strong></h5>
								</td>
							</tr>
							<tr>
								<table class="table">
									<thead>
										<tr>
											<td><h5><strong>CÓDIGO</strong></h5></td>
											<td><h5><strong>DENOMINACIÓN</strong></h5></td>
											<td><h5><strong>DEBE</strong></h5></td>
											<td><h5><strong>HABER</strong></h5></td>
										</tr>
									</thead>
									<tbody>
										<tr v-for="record in props.row.accounting_accounts">
											<td>
												<h5>
													{{
														record.account.group +'.'+
														record.account.subgroup +'.'+
														record.account.item +'.'+
														record.account.generic +'.'+
														record.account.specific +'.'+
														record.account.subspecific
													}}
												</h5>
											</td>
											<td>
												<h5>{{ record.account.denomination }}</h5>
											</td>
											<td>
												<h5>{{ record.debit }}</h5>
											</td>
											<td>
												<h5>{{ record.assets }}</h5>
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
		props:['seating','show'],
		data(){
			return{
				records: [],
				columns: ['content'],
				url:'http://'+window.location.host+'/accounting/seating',
			}
		},
		created(){
			this.table_options.headings = {
				'content': 'ASIENTOS CONTABLES',
			};
			this.records = this.seating;
		},
		methods:{
			print:function(id) {
				alert('print');
			},
			approve:function(index) {
				var url = this.url+'/approve';
    			var records = this.records;
    			var confirmated = false;
				var index = index - 1;

				bootbox.confirm({
	    			title: "Aprobar Asiento?",
	    			message: "Esta seguro de aprobar este asiento?",
	    			buttons: {
	    				cancel: {
	    					label: '<i class="fa fa-times"></i> Cancelar'
	    				},
	    				confirm: {
	    					label: '<i class="fa fa-check"></i> Confirmar'
	    				}
	    			},
	    			callback: function (result) {
						if (result) {
	    					confirmated = true;
							axios.post(url + '/' + records[index].id).then(response => {
								if (typeof(response.data.error) !== "undefined") {
									/** Muestra un mensaje de error si sucede algún evento en la eliminación */
	    							vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
	    							return false;
								}
								records.splice(index, 1);
								vm.showMessage('update');
							}).catch(error => {});
	    				}
	    			}
	    		});

	    		if (confirmated) {
	    			this.records = records;
	    			this.showMessage('update');
	    		}

			},
		}
	}

</script>