<template>
	<section>
		<div class="form-group form-inline pull-left VueTables__search-2">
			<div class="VueTables__search-field">
				<label class="">
					Buscar:
				</label>
				<input  type="text"
						class="form-control"
						placeholder="Buscar..."
						title="Filtrar resultados"
						data-toggle="tooltip"
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
			<div slot="institution" slot-scope="props" class="text-center">
				<span>
					{{ (props.row.institution)?props.row.institution.acronym:'N/A' }}
				</span>
			</div>
			<div slot="asset_condition" slot-scope="props" class="text-center">
				<span>
					{{ (props.row.asset_condition)?props.row.asset_condition.name:'N/A' }}
				</span>
			</div>
			<div slot="asset_status" slot-scope="props" class="text-center">
				<span>
					{{ (props.row.asset_status)?props.row.asset_status.name:'N/A' }}
				</span>
			</div>
			<div slot="id" slot-scope="props" class="text-center">
				<div class="d-inline-flex">
					<asset-info
		            		:route_list="'asset/registers/info/'+ props.row.id">
		        	</asset-info>

					<button @click="assignAsset(props.row.id)"
		    				class="btn btn-primary btn-xs btn-icon btn-action"
		    				title="Asignar Bien" data-toggle="tooltip" :disabled="(props.row.asset_status_id == 10)?false:true"
		    				type="button">
		    			<i class="fa fa-filter"></i>
		    		</button>
		    		<button @click="disassignAsset(props.row.id)"
		    				class="btn btn-danger btn-xs btn-icon btn-action"
		    				title="Desincorporar Bien" data-toggle="tooltip" :disabled="((props.row.asset_status_id < 6)||(props.row.asset_status_id > 9))?false:true"
		    				type="button">
		    			<i class="fa fa-chain"></i>
		    		</button>

					<button @click="editForm(props.row.id)"
		    				class="btn btn-warning btn-xs btn-icon btn-action"
		    				title="Modificar registro" data-toggle="tooltip" type="button">
		    			<i class="fa fa-edit"></i>
		    		</button>
		    		<button @click="deleteRecord(props.index, '')"
							class="btn btn-danger btn-xs btn-icon btn-action"
							title="Eliminar registro" data-toggle="tooltip"
							type="button">
						<i class="fa fa-trash-o"></i>
					</button>
				</div>
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
                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="lastPage != page">
                        <a class="page-link" @click="changePage(lastPage)">ÚLTIMO</a>
                    </li>
				</ul>
				<p class="VuePagination__count text-center col-md-12" style=""> </p>
			</nav>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
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
				columns: [
                    'inventory_serial', 'institution', 'asset_condition','asset_status','serial','marca','model', 'id'
                ]
			}
		},
		created() {
			this.table_options.headings = {
				'inventory_serial': 'Código',
				'institution': 'Organización',
				'asset_condition': 'Condición física',
				'asset_status': 'Estatus de uso',
				'serial': 'Serial',
				'marca': 'Marca',
				'model': 'Modelo',
				'id': 'Acción'
			};
			this.table_options.sortable = [
                'inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'
            ];
			this.table_options.filterable = [
                'inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'
            ];
			this.table_options.orderBy = { 'column': 'id'};
		},
		mounted () {
			this.initRecords(this.route_list, '');
		},
		watch: {
            perPage(res) {
            	if (this.page == 1){
            		this.initRecords(this.route_list + '/' + res, '');
            	} else {
            		this.changePage(1);
            	}
            },
            page(res) {
                this.initRecords(this.route_list + '/' + this.perPage + '/' + res, '');
            }
        },
		methods: {

			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {

			},

			/**
			 * Redirige al formulario de asignación de bienes institucionales
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 *
			 * @param [Integer] $id Identificador único del bien
			 */
			assignAsset(id)
			{
				location.href = '/asset/asignations/asset/' + id;
			},

			/**
			 * Redirige al formulario de desincorporación de bienes institucionales
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 *
			 * @param [Integer] $id Identificador único del bien
			 */
			disassignAsset(id)
			{
				location.href = '/asset/disincorporations/asset/' + id;
			},
			/**
			 * Cambia la pagina actual de la tabla
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
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
			 * Reescribe el método initRecords para cambiar su comportamiento por defecto
	         * Inicializa los registros base del formulario
	         *
	         * @author Henry Paredes <hparedes@cenditel.gob.ve>
	         *
	         * @param {string} url      Ruta que obtiene los datos a ser mostrado en listados
	         * @param {string} modal_id Identificador del modal a mostrar con la información solicitada
	         */
	        initRecords(url, modal_id) {
	            this.errors = [];
	            this.reset();
	            const vm = this;

	            axios.get(url).then(response => {
	                if (typeof(response.data.records) !== "undefined") {
	                    vm.records  = response.data.records;
						vm.total    = response.data.total;
						vm.lastPage = response.data.lastPage;
						vm.$refs.tableMax.setLimit(vm.perPage);
	                }
	                if ($("#" + modal_id).length) {
	                    $("#" + modal_id).modal('show');
	                }
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
		}
	};
</script>
