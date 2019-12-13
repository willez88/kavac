<template>
	<div>
		<section>
		<div class="form-group form-inline pull-left VueTables__search-2">
			<div class="VueTables__search-field">
				<label class="">
					Buscar:
				</label>
				<input  type="text"
						class="form-control"
						placeholder="Buscar..."
						v-model="search">
			</div>
		</div>

		<div class="form-group form-inline pull-right VueTables__limit-2">
			<div class="VueTables__limit-field">
				<label class="">Registros</label>
				<select2 :options="perPageValues"
					v-model="perPage">
				</select2>
			</div>
		</div>
		<v-client-table :columns="columns" :data="records" :options="table_options" ref="tableMax">
			<div slot="from_date" slot-scope="props" class="text-center">
                {{ formatDate(props.row.from_date) }}
            </div>
            <div slot="reference" slot-scope="props" class="text-center">
                {{ props.row.reference }}
            </div>
            <div slot="total" slot-scope="props" class="text-right">
                <strong>Debe: </strong> 
                {{ props.row.currency.symbol }} {{ parseFloat(props.row.tot_debit).toFixed(props.row.currency.decimal_places) }}
                <br>
                <strong>Haber</strong> 
                {{ props.row.currency.symbol }} {{ parseFloat(props.row.tot_assets).toFixed(props.row.currency.decimal_places) }}
            </div>
            <div slot="approved" slot-scope="props" class="text-center">
                <span class="badge badge-success" v-show="props.row.approved"><strong>Aprobado</strong></span>
                <span class="badge badge-danger" v-show="!props.row.approved"><strong>No Aprobado</strong></span>
            </div>
            <div slot="id" slot-scope="props" class="text-center">
                <button @click="approve(props.index)"
                        class="btn btn-success btn-xs btn-icon btn-action" 
                        title="Aprobar Registro" data-toggle="tooltip"
                        v-if="!props.row.approved">
                    <i class="fa fa-check"></i>
                </button>
                <button @click="editForm(props.row.id)"
                        class="btn btn-warning btn-xs btn-icon btn-action" 
                        title="Modificar registro" data-toggle="tooltip"
                        v-if="!props.row.approved">
                    <i class="fa fa-edit"></i>
                </button>
                <button @click="deleteRecord(props.index,'/accounting/entries')" 
                        class="btn btn-danger btn-xs btn-icon btn-action" 
                        title="Eliminar Registro" data-toggle="tooltip"
                        v-if="!props.row.approved">
                    <i class="fa fa-trash-o"></i>
                </button>
                <a class="btn btn-primary btn-xs btn-icon"
                        :href="urlPdf+'/pdf/'+props.row.id"
                        title="Imprimir Registro" 
                        data-toggle="tooltip"
                        target="_blank"
                        v-if="props.row.approved">
                        <i class="fa fa-print" style="text-align: center;"></i>
                </a>
            </div>
		</v-client-table>
		<div class="VuePagination-2 row col-md-12 ">
			<nav class="text-center">
				<ul class="pagination VuePagination__pagination" style="">
					<li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="page != 1">
                        <a class="page-link" @click="changePage(1)">PRIMERO</a>
                    </li>
					<li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk disabled">
                        <a class="page-link">&lt;&lt;</a>
                    </li>
                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-page" v-if="page > 1">
                        <a class="page-link" @click="changePage(page - 1)">&lt;</a>
                    </li>
                    <li :class="(page == number)?'VuePagination__pagination-item page-item active':'VuePagination__pagination-item page-item'" v-for="number in pageValues" v-if="number <= lastPage">
                        <a class="page-link active" role="button" @click="changePage(number)">{{number}}</a>
                    </li>
                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-page" v-if="page < lastPage">
                        <a class="page-link" @click="changePage(page + 1)">&gt;</a>
                    </li>
                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-chunk disabled">
                        <a class="page-link">&gt;&gt;</a>
                    </li>
                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="lastPage && lastPage != page">
                        <a class="page-link" @click="changePage(lastPage)">ÚLTIMO</a>
                    </li>
				</ul>
				<p class="VuePagination__count text-center col-md-12" style=""> </p>
			</nav>
		</div>
	</section>
	</div>
</template>
<style type="text/css">
	.VueTables__search {
		display: none;
	}
	.VueTables__limit {
		display: none;
	}
	.VuePagination {
		display: none;
	}
</style>
<script>
	export default{
		props:{
            entries:{
                type:Array,
                default: function() {
                	return [];
                }
            },
        },
		data(){
			return {
				url:'/accounting/entries/Filter-Records',
				dataForm:{},
				records: [],
				search: '',
				page: 1,
				total: '',
				perPage: 10,
				lastPage: '',
				pageValues: [1,2,3,4,5,6,7,8,9,10],
				perPageValues: [
					{
						'id': 10,
						'text': '10'
					},
					{
						'id': 25,
						'text': '25'
					},
					{
						'id': 50,
						'text': '50'
					}
				],

				urlPdf:'/accounting/entries',
				columns: ['from_date', 'reference', 'concept', 'total', 'approved', 'id']
			}
		},
		watch: {
            perPage(res) {
            	if (this.page == 1){
            		this.initRecords(this.url + '/' + res, '');
            	} else {
            		this.changePage(1);
            	}
            },
            page(res) {
                this.initRecords(this.url + '/' + this.perPage + '/' + res, '');
            },
            search(res){
            	this.changePage(1);
            	this.initRecords(this.url);
            }
        },
        methods:{

        	/**
			 * Cambia la pagina actual de la tabla
			 *
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 * 
			 * @param [Integer] $page Número de pagina actual
			 */
			changePage(page) {
                const vm = this;
                vm.page = page;
                var pag = 0;
                while(1) {
                    if (pag + 10 >= vm.page) {
                        pag += 1;
                        break;
                    } else {
                        pag += 10;
                    }
                }
                vm.pageValues = [];
                for (var i = 0; i < 10; i++) {
                    vm.pageValues.push(pag + i);
                }
            },

            /**
			 * Reescribe el método initRecords para cambiar su comportamiento por defecto y realiza la consulta
			 * en base a la informacion del formulario
	         *
	         * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	         *
	         * @param {string} url      Ruta que obtiene los datos a ser mostrado en listados
	         */
	        initRecords(url) {
	            const vm = this;
	            vm.dataForm['search'] = vm.search;
	            axios.post(url, vm.dataForm).then(response=>{
					if (response.data.records.length == 0) {
						vm.showMessage(
                                'custom', 'Error', 'danger', 'screen-error', "No se encontraron asientos contables aprobados con los parámetros de busqueda dados."
                            );
					}else{
						if (vm.dataForm['firstSearch']) {
							vm.showMessage('custom', 'Éxito', 'success', 'screen-ok', 'Busqueda realizada de manera exitosa.');
							vm.dataForm['firstSearch'] = false;
						}
					}
					vm.records = response.data.records;
					vm.total = response.data.total;
					vm.lastPage = response.data.lastPage;
					vm.$refs.tableMax.setLimit(vm.perPage);
				}).catch(error => {
					if (typeof(error.response) !== "undefined") {
	                    if (error.response.status == 403) {
	                        vm.showMessage(
	                            'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
	                        );
	                    }
	                    else {
	                        vm.logs('resources/js/all.js', 343, error, 'initRecords');
	                    }
	                }
				});
	        },
        },
		created(){
			this.table_options.headings = {
                'from_date': 'FECHA',
                'reference': 'REFERENCIA',
                'concept'  : 'CONCEPTO',
                'total'    : 'TOTAL',
                'approved' : 'ESTADO DEL ASIENTO',
                'id'       : 'ACCIÓN'
            };
            this.table_options.sortable   = [];
            this.table_options.filterable = [];
            this.table_options.columnsClasses = {
                'from_date'   : 'col-xs-1',
                'reference'   : 'col-xs-1',
                'denomination': 'col-xs-5',
                'total'       : 'col-xs-2',
                'approved'    : 'col-xs-1',
                'id'          : 'col-xs-2'
            };

			this.table_options.filterable = [];
			if (this.entries) {
				this.records = this.entries;
			}
			EventBus.$on('reload:listing',(data)=>{
				this.records = data;
			});

			EventBus.$on('list:entries',(data)=>{
				this.search = '';
				this.dataForm = data;
				this.initRecords(this.url);
			});
		},
	};

</script>
