<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Gráficos del Inventario de Productos en Almacén</h6>
			<div class="card-btns">
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-3">
					<div class=" form-group">
						<label>Existencia</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
    							<input type="radio" name="type_graph_products" value="exist" id="sel_product_exist"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_graph_products"
    								   data-on-label="SI" data-off-label="NO" checked>
                            </div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class=" form-group">
						<label>Más solicitados</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
    							<input type="radio" name="type_graph_products" value="max_request"
                                       id="sel_product_max_request" data-on-label="SI" data-off-label="NO"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_graph_products">
                            </div>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class=" form-group">
						<label>Menos solicitados</label>
						<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
    							<input type="radio" name="type_graph_products" value="min_request"
                                       id="sel_product_min_request" data-on-label="SI" data-off-label="NO"
    								   class="form-control bootstrap-switch bootstrap-switch-mini sel_graph_products">
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
	            <div class="col-md-8"></div>
	            <div class="col-md-4 d-inline-flex">
	                <div class="dropdown">
	                    <a href="#" class="dropdown-toggle btn btn-sm btn-default btn-custom" id="list_options_diagram"
	                       data-toggle="dropdown" aria-expanded="false" title="">
	                       <i class="fa fa-refresh" style="color: white;" v-if="this.type =='doughnut'"></i>
	                       <i class="fa fa-pie-chart" style="color: white;" v-if="this.type =='pie'"></i>
	                       <i class="fa fa-line-chart" style="color: white;" v-if="this.type =='line'"></i>
	                       <i class="fa fa-bar-chart" style="color: white;" aria-hidden="true" v-if="this.type =='bar'"></i>
	                       <i class="fa fa-stop" style="color: white;" aria-hidden="true" v-if="this.type ==''"></i>
	                    </a>
	                    <div class="dropdown-menu dropdown-menu-right"
	                         aria-labelledby="list_options_diagram">
	                         <div class="d-inline-flex">
	                            <a class="dropdown-item btn btn-sm btn-default" @click="updateGraphType('bar')"
	                               title="Vizualizar en gráfico de barras" data-toggle="tooltip">
	                                <i class="fa fa-bar-chart" style="color: white;"></i>
	                            </a>
	                            <a class="dropdown-item btn btn-sm btn-default" @click="updateGraphType('doughnut')"
	                               title="Vizualizar en gráfico de dona" data-toggle="tooltip">
	                                <i class="fa fa-refresh" style="color: white;"></i>
	                            </a>
	                            <a class="dropdown-item btn btn-sm btn-default" @click="updateGraphType('pie')"
	                               title="Vizualizar en gráfico de torta" data-toggle="tooltip">
	                                <i class="fa fa-pie-chart" style="color: white;"></i>
	                            </a>
                                <a class="dropdown-item btn btn-sm btn-default" @click="updateGraphType('line')"
                                   title="Vizualizar en gráfico de linea" data-toggle="tooltip">
                                    <i class="fa fa-line-chart" style="color: white;"></i>
                                </a>
	                         </div>
	                    </div>
	                </div>
            	</div>
        	</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<warehouse-graph-charts
						:data="data"
						:labels="labels"
						:type="type"
						:descriptions="descriptions"
						:title="title">
					</warehouse-graph-charts>
				</div>
			</div>
			<!-- Controles -->
	        <div class="VuePagination row col-md-12" v-if="records.length > 0">
	            <nav class="text-center">
	                <ul class="pagination VuePagination__pagination" style="">
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="pag != 1">
	                        <a class="page-link" @click="firstPag()">PRIMERO</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="pag > num_pag">
	                        <a class="page-link" @click="delPag()">&lt;&lt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-page" v-if="pag > 1">
	                        <a class="page-link" @click="prevPag()">&lt;</a>
	                    </li>
	                    <li :class="(pag ==number)?'VuePagination__pagination-item page-item active':'VuePagination__pagination-item page-item'" v-for="number in numbers" v-if="records.length >= number">
	                        <a class="page-link active" role="button" @click.prevent="pag = number">{{number}}</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-page" v-if="records.length > pag">
	                        <a class="page-link" @click="nextPag()">&gt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-chunk" v-if="checkPag(num_pag)">
	                        <a class="page-link" @click="addPag()">&gt;&gt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="records.length != pag">
	                        <a class="page-link" @click="lastPag()">ÚLTIMO</a>
	                    </li>
	                </ul>

	            </nav>
	        </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					type_graph_products: 'exist',
				},
				errors: [],
				records: [],

				/** Paginador */
				num_pag: 10,    /** Número de páginas visibles */
            	pag: 1,         /** Página actual */

				/** Grafico */
				type: "bar",    /** Gráfico actual */
				title: "Productos Registrados",
				numbers: [1,2,3,4,5,6,7,8,9,10],
				data: [],
				labels: [],
				descriptions: [],
			}
		},
		methods: {
			reset() {
				this.num_pag = 10;    /** Número de páginas visibles */
            	this.pag = 1;         /** Página actual */
            	this.type = "bar";    /** Gráfico actual */
				this.errors = [];
				this.record = {
					type_graph_products: 'exist'
				};
			},
			checkPag(num_pag) {
                const vm = this;
                if (vm.records.length > num_pag) {
                    if (vm.pag <= num_pag){
                        return true;
                    } else
                        return vm.checkPag(num_pag + vm.num_pag);
                }
                else
                    return false;
            },
            firstPag() {
            	const vm = this;
            	vm.pag = 1;
            	vm.numbers = [1,2,3,4,5,6,7,8,9,10];
            },
            lastPag() {
            	const vm = this;
            	vm.pag = vm.records.length;
            	var pag = 0;
            	while(1) {
            		if (pag + vm.num_pag >= vm.pag) {
            			pag += 1;
            			break;
            		} else {
            			pag += vm.num_pag;
            		}
            	}
            	vm.numbers = [];
            	for (var i = 0; i < 10; i++) {
            		vm.numbers.push(pag + i);
            	}
            },
            prevPag() {
            	const vm = this;
            	vm.pag -= 1;
            	var pag = 0;
            	while(1) {
            		if (pag + vm.num_pag >= vm.pag) {
            			pag += 1;
            			break;
            		} else {
            			pag += vm.num_pag;
            		}
            	}
            	vm.numbers = [];
            	for (var i = 0; i < 10; i++) {
            		vm.numbers.push(pag + i);
            	}
            },
            nextPag() {
            	const vm = this;
            	vm.pag += 1;
            	var pag = 0;
            	while(1) {
            		if (pag + vm.num_pag >= vm.pag) {
            			pag += 1;
            			break;
            		} else {
            			pag += vm.num_pag;
            		}
            	}
            	vm.numbers = [];
            	for (var i = 0; i < 10; i++) {
            		vm.numbers.push(pag + i);
            	}
            },
            addPag() {
            	const vm = this;
            	var i = 1;
            	var pag = vm.pag;
            	while(1) {
            		if (pag <= vm.num_pag) {
            			vm.pag = i * vm.num_pag + 1;
            			break;
            		} else {
            			pag -= vm.num_pag;
            			i++;
            		}
            	}
            	vm.numbers = [];
            	for (var i = 0; i < 10; i++) {
            		vm.numbers.push(vm.pag + i);
            	}
            },
            delPag() {
            	const vm = this;
            	var i = 0;
            	var pag = vm.pag;
            	while(1) {
            		if (pag <= 2*vm.num_pag) {
            			vm.pag = vm.num_pag * i + 1;
            			break;
            		}
            		else {
            			pag -= vm.num_pag;
            			i++;
            		}
            	}
            	vm.numbers = [];
            	for (var i = 0; i < 10; i++) {
            		vm.numbers.push(vm.pag + i);
            	}
            },
            update() {
				const vm = this;
				vm.records = [];
				var fields = [];
				var index = 0;
				if (vm.record.type_graph_products == 'exist') {
                    vm.title = "Productos Registrados";
					axios.get('/warehouse/get-warehouse-inventory-products/exist').then(response => {
						if (typeof(response.data.records) != "undefined") {
							if (response.data.records.length > 5) {
								$.each(response.data.records, function(indice, field) {
									if (index < 5) {
										fields.push(field);
										index++;
									} else {
										vm.records.push(fields);
										index = 0;
										fields = [];
									}
								});
								if (fields.length > 0) {
									vm.records.push(fields);
								}

							} else {
								fields = response.data.records;
								vm.records.push(fields);
							}
							vm.updateGraphData();
						}
					});
				} else if (vm.record.type_graph_products == 'min_request') {
                    vm.title = "Productos Menos Solicitados";
					axios.get('/warehouse/get-warehouse-inventory-products/request/asc').then(response => {
						if (typeof(response.data.records) != "undefined") {
							if (response.data.records.length > 5) {
								$.each(response.data.records, function(indice, field) {
									if (index < 5) {
										fields.push(field);
										index++;
									} else {
										vm.records.push(fields);
										index = 0;
										fields = [];
									}
								});
								if (fields.length > 0) {
									vm.records.push(fields);
								}

							} else {
								fields = response.data.records;
								vm.records.push(fields);
							}
							vm.updateGraphData();
						}
					});
				} else if (vm.record.type_graph_products == 'max_request') {
                    vm.title = "Productos Mas Solicitados";
					axios.get('/warehouse/get-warehouse-inventory-products/request/desc').then(response => {
						if (typeof(response.data.records) != "undefined") {
							if (response.data.records.length > 5) {
								$.each(response.data.records, function(indice, field) {
									if (index < 5) {
										fields.push(field);
										index++;
									} else {
										vm.records.push(fields);
										index = 0;
										fields = [];
									}
								});
								if (fields.length > 0) {
									vm.records.push(fields);
								}

							} else {
								fields = response.data.records;
								vm.records.push(fields);
							}
							vm.updateGraphData();
						}
					});
				}
			},
			updateGraphData() {
				const vm = this;
				var fields = [];
				var data = [];
				var labels = [];
				var descriptions = [];

				if (vm.records.length > 0) {
					fields = vm.records[vm.pag-1];
					if(vm.record.type_graph_products == 'exist') {
						$.each(fields, function(indice, field) {
							data.push(field.exist);
							labels.push(field.code);
							descriptions.push((field.warehouse_product.measurement_unit)
                                ? ('Unidad: ' + field.warehouse_product.measurement_unit)
                                : ''
                            );
						});
					} else {
						$.each(fields, function(indice, field) {
							data.push((field.reserved == null)?0:field.reserved);
							labels.push(field.code);
							descriptions.push((field.warehouse_product.measurement_unit)
                                ? ('Unidad: ' + field.warehouse_product.measurement_unit)
                                : ''
                            );
						});
					}
					vm.data = data;
					vm.labels = labels;
					vm.descriptions = descriptions;
				}
			},
            updateGraphType(type) {
                if (type != this.type) {
                    this.type = type;
                    this.update();
                }
            }
		},
		mounted() {
			const vm = this;
            vm.reset();
			vm.switchHandler('type_graph_products');
            vm.update();

            $('.sel_graph_products').on('switchChange.bootstrapSwitch', function(e) {
                vm.update();
            });
		},
		watch: {
            pag: function(pag) {
                this.updateGraphData();
            },
        }
	};
</script>
