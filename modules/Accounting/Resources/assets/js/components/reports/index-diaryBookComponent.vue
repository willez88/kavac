<template>
	<div class="form-horizontal">
		<div class="card-body">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<label class="control-label">Periodo Inicial</label>
					<input type="date" class="form-control is-required"
						v-model="dateIni">
				</div>
				<div class="col-4">
					<label class="control-label">Periodo Final</label>
					<input type="date" class="form-control is-required"
						v-model="dateEnd">
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<div class="card-footer text-right">
			<a :href="url+orderDate()"
				class="btn btn-success btn-icon btn-round"
				data-toggle="tooltip"
				target="_blank"
				:disabled="(dateIni == '' || dateEnd == '')"
				title="Realizar busqueda">
				<i class="fa fa-search"></i>
			</a>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				url:'/accounting/report/diaryBook/pdf/',
				dateIni:'',
				dateEnd:'',
			}
		},
		methods:{
			orderDate(){
				
				var dateIni = this.dateIni.split('-')[2]+'-'+this.dateIni.split('-')[1]+'-'+this.dateIni.split('-')[0];
				var dateEnd = this.dateEnd.split('-')[2]+'-'+this.dateEnd.split('-')[1]+'-'+this.dateEnd.split('-')[0];

				return (dateIni <= dateEnd)?(dateIni+'/'+dateEnd):(dateEnd+'/'+dateIni);
			}
		}
	}
</script>