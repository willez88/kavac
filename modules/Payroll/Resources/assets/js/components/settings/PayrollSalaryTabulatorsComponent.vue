<template>
	<section id="PayrollSalaryTabulatorComponent">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros Tabuladores de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_payroll_salary_tabulator', 'salary-tabulators', $event)">
			<i class="icofont icofont-table ico-3x"></i>
			<span>Tabuladores de Nónima</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_salary_tabulator">
			<div class="modal-dialog modal-lg vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-table ico-2x"></i>
							 Nuevo Tabulador
						</h6>
					</div>

					<div class="modal-body">
                		<div class="alert alert-danger" v-if="errors.length > 0">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        @click.prevent="errors = []">
                                    <span aria-hidden="true">
                                        <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </span>
                                </button>
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="wizard-tabs with-border">
                            <ul class="nav wizard-steps">
                                <li class="nav-item active">
                                    <a href="#w-tabulatorForm" data-toggle="tab" class="nav-link text-center" id="tabuladorForm">
                                        <span class="badge">1</span>
                                        Definir Tabulador
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#w-tabulatorShow" data-toggle="tab" class="nav-link text-center" id="tabuladorShow">
                                        <span class="badge">2</span>
                                        Cargar Tabulador
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal">
                            <div class="tab-content">
                                <div id="w-tabulatorForm" class="tab-pane p-3 active">
            						<div class="row">
            							<div class="col-md-6">
                                            <div class=" form-group is-required">
                                                <label>Nombre</label>
                                                <input type="text" placeholder="Nombre del tabulador" data-toggle="tooltip"
                                                       class="form-control input-sm" v-model="record.name">
                                                <input type="hidden" v-model="record.id">
                                            </div>
            								<div class="row">
            									<div class="col-md-4">
            										<div class="form-group">
            											<label>¿Activa?</label>
                                                        <div class="col-12">
                                                            <div class="pretty p-switch p-fill p-bigger p-toggle">
                                                                <input type="checkbox" v-model="record.active">
                                                                    <div class="state p-off">
                                                                        <label>NO</label>
                                                                    </div>
                                                                    <div class="state p-on p-success">
                                                                        <label>SI</label>
                                                                    </div>
                                                            </div>
                                                        </div>
            										</div>
            									</div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Moneda:</label>
                                                        <select2 :options="currencies" v-model="record.currency_id"></select2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group is-required">
                                                <label>Tipo de Personal</label>
                                                <v-multiselect :options="payroll_staff_types" track_by="text"
                                                               :hide_selected="false"
                                                               v-model="record.payroll_staff_types">
                                                </v-multiselect>
                                            </div>
            							</div>
            							<div class="col-md-6">
                                            <div class="form-group">
                                                <label>Descripción:</label>
                                                <ckeditor :editor="ckeditor.editor" id="description_tabulator" data-toggle="tooltip"
                                                          title="Indique alguna descripción asociada al tabulador"
                                                          :config="ckeditor.editorConfig" class="form-control"
                                                          name="description_tabulator" tag-name="textarea" rows="2"
                                                          v-model="record.description"></ckeditor>
                                            </div>
            							</div>
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Institución:</label>
                                                <select2 :options="institutions" v-model="record.institution_id"></select2>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Tipo de tabulador:</label>
                                                <select2 :options="payroll_salary_tabulator_types"
                                                         @input="getPayrollSalaryScales()"
                                                         v-model="record.payroll_salary_tabulator_type"></select2>
                                            </div>
                                        </div>
                                        <div class="col-md-6"
                                             v-if="record.payroll_salary_tabulator_type &&
                                                   record.payroll_salary_tabulator_type != 'mixed'">
                                            <div class="form-group is-required">
                                                <label>Escalafón:</label>
                                                <select2 :options="payroll_horizontal_salary_scales"
                                                         v-if="record.payroll_salary_tabulator_type =='horizontal'"
                                                         v-model="record.payroll_horizontal_salary_scale_id"></select2>
                                                <select2 :options="payroll_vertical_salary_scales"
                                                         v-else
                                                         v-model="record.payroll_vertical_salary_scale_id"></select2>
                                            </div>
                                        </div>
            						</div>
                                    <div class="row"
                                         v-if="record.payroll_salary_tabulator_type == 'mixed'">
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Escalafón horizontal:</label>
                                                <select2 :options="payroll_horizontal_salary_scales"
                                                         @input="loadSalaryScale('horizontal')"
                                                         v-model="record.payroll_horizontal_salary_scale_id"></select2>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group is-required">
                                                <label>Escalafón vertical:</label>
                                                <select2 :options="payroll_vertical_salary_scales"
                                                         @input="loadSalaryScale('vertical')"
                                                         v-model="record.payroll_vertical_salary_scale_id"></select2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="w-tabulatorShow" class="tab-pane p-3">
                                    <!-- Visible para ambos escalafones -->
                                    <div class="modal-table"
                                         v-if="((record.payroll_horizontal_salary_scale_id > 0)
                                            && (payroll_salary_scale_h.payroll_scales.length > 0))
                                            || ((record.payroll_vertical_salary_scale_id > 0)
                                            && (payroll_salary_scale_v.payroll_scales.length > 0))">
                                        <table class="table table-hover table-striped table-responsive  table-assignment"
                                               v-if="record.payroll_horizontal_salary_scale_id > 0">
                                            <thead>
                                                <th :colspan="1 + payroll_salary_scale_h.payroll_scales.length">
                                                    <strong>{{ record.name }}</strong>
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <th>Nombre:</th>
                                                    <th
                                                        v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
                                                        {{field_h.name}}
                                                    </th>
                                                </tr>
                                                <tr class="text-center"
                                                    v-if="payroll_salary_scale_v.payroll_scales.length == 0">
                                                    <th>Incidencia:</th>
                                                    <td class="td-with-border"
                                                        v-for="(field_h, index) in payroll_salary_scale_h.payroll_scales">
                                                        <div>
                                                            <input type="number" :id="'salary_scale_h_' + field_h.id"
                                                                   class="form-control input-sm" data-toggle="tooltip" min="0"
                                                                   step=".01" onfocus="this.select()">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr class="text-center" v-else
                                                    v-for="(field_v, index_v) in payroll_salary_scale_v.payroll_scales">
                                                    <th
                                                        v-if="((record.payroll_vertical_salary_scale_id > 0) &&
                                                            (payroll_salary_scale_v.payroll_scales.length > 0))">
                                                        {{field_v.name}}
                                                    </th>
                                                    <td class="td-with-border"
                                                        v-for="(field_h, index_h) in payroll_salary_scale_h.payroll_scales">
                                                        <div>
                                                            <input type="number" class="form-control input-sm"
                                                                   :id="'salary_scale_' + field_v.id + '_' + field_h.id"
                                                                   data-toggle="tooltip" min="0" step=".01" onfocus="this.select()">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table  class="table table-hover table-striped table-responsive  table-assignment"
                                                v-else-if="record.payroll_horizontal_salary_scale_id == ''
                                                    && record.payroll_vertical_salary_scale_id > 0
                                                    && payroll_salary_scale_v.payroll_scales.length > 0">
                                            <thead>
                                                <th colspan="2">
                                                    <strong>{{ record.name }}</strong>
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <th>Código</th>
                                                    <th>Incidencia</th>
                                                </tr>
                                                <tr class="text-center"
                                                    v-for="(field, index) in payroll_salary_scale_v.payroll_scales">
                                                    <th>
                                                        {{field.name}}
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <input type="number" :id="'salary_scale_v_' + field.id"
                                                                   class="form-control input-sm" data-toggle="tooltip" min="0"
                                                                   step=".01" onfocus="this.select()">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <button type="button" @click="changePanel('Show')"
                                            class="btn btn-primary btn-wd btn-sm"
                                            data-toggle="tooltip" title=""
                                            >
                                        Siguiente
                                    </button>
                                </div>
                                <div class="pull-left">
                                    <button type="button" @click="changePanel('Form')"
                                            class="btn btn-default btn-wd btn-sm"
                                            data-toggle="tooltip" title=""
                                            >
                                        Regresar
                                    </button>
                                </div>
                            </div>
                        </form>
			        </div>
			        <div class="modal-footer">
                        <div class="form-group">
                            <modal-form-buttons :saveRoute="'payroll/salary-tabulators'"></modal-form-buttons>
                        </div>
                    </div>
                    <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="exportRecord(props.index, $event)"
                                        class="btn btn-primary btn-xs btn-icon btn-action"
                                        title="Descargar/Exportar tabulador" data-toggle="tooltip" type="button">
	                                <i class="fa fa-download"></i>
	                            </button>
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'salary-tabulators')"
										class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar registro"
                                        data-toggle="tooltip" type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
		        </div>
		    </div>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id:                              '',
                    name:                            '',
                    active:                          '',
                    description:                     '',
                    institution_id:                  '',
                    currency_id:                     '',
                    payroll_salary_tabulator_type:   '',
                    payroll_staff_types:             [],

                    payroll_horizontal_salary_scale_id: '',
                    payroll_vertical_salary_scale_id:   '',
                    payroll_salary_tabulator_scales: []
				},
                errors:                         [],
                records:                        [],
                columns:                        ['name', 'description', 'id'],
                payroll_salary_tabulator_types: [
                    {"id": "",           "text": "Seleccione..."},
                    {"id": "horizontal", "text": "Horizontal"},
                    {"id": "vertical",   "text": "Vertical"},
                    {"id": "mixed",      "text": "Mixto"}
                ],
                institutions:                   [],
                currencies:                     [],
                payroll_staff_types:            [],
                payroll_horizontal_salary_scales: [],
                payroll_vertical_salary_scales: [],
                payroll_salary_scale_h: [],
                payroll_salary_scale_v: [],

			}
		},
		created() {
            const vm = this;
			vm.table_options.headings = {
				'name':        'Nombre',
				'description': 'Descripción',
				'id':          'Acción'
			};
			vm.table_options.sortable       = ['name', 'description'];
			vm.table_options.filterable     = ['name', 'description'];
			vm.table_options.columnsClasses = {
				'name':        'col-xs-4',
				'description': 'col-xs-6',
				'id':          'col-xs-2'
			};
		},
        mounted() {
            const vm = this;
            $("#add_payroll_salary_tabulator").on('show.bs.modal', function() {
                vm.reset();
                vm.getPayrollStaffTypes();
                vm.getInstitutions();
                vm.getCurrencies();
            });
            vm.switchHandler('active');
        },
		methods: {
            changePanel(panel) {
                const vm = this;
                let element = document.getElementById('tabulador' + panel);
                element.click();
            },
            loadSalaryScale(ladder) {
                const vm = this;

                if (ladder == 'horizontal') {
                    if(vm.record.payroll_horizontal_salary_scale_id > 0) {
                        var id = vm.record.payroll_horizontal_salary_scale_id;
                        axios.get('/payroll/salary-scales/info/'+ id).then(response => {
                            vm.payroll_salary_scale_h = response.data.record;
                        });
                    }
                } else if (ladder == 'vertical') {
                    if(vm.record.payroll_vertical_salary_scale_id > 0) {
                        var id = vm.record.payroll_vertical_salary_scale_id;
                        axios.get('/payroll/salary-scales/info/'+ id).then(response => {
                            vm.payroll_salary_scale_v = response.data.record;
                        });
                    }
                }
            },
			reset() {
				const vm  = this;
                vm.errors = [];
				vm.record = {
					id:                              '',
                    name:                            '',
                    active:                          '',
                    description:                     '',
                    institution_id:                  '',
                    currency_id:                     '',
                    payroll_salary_tabulator_type:   '',
                    payroll_staff_types:             [],
                    payroll_salary_tabulator_scales: {}
				};
                vm.payroll_salary_scales_h = [];
                vm.payroll_salary_scales_v = [];

			},
			exportRecord(index, event) {
				const vm = this;
				var fields = vm.records[index - 1];
				window.open('/payroll/salary-tabulators/export/' + fields.id);
				event.preventDefault();
			},
            getPayrollSalaryScales(ladder = 'all') {
                const vm = this;
                let except_id = null;
                if (ladder == 'vertical')
                    except_id = vm.record.payroll_horizontal_salary_scale_id;
                else if (ladder == 'horizontal')
                    except_id = vm.record.payroll_vertical_salary_scale_id;
                let field = {
                    institution_id: vm.record.institution_id,
                    except_id: except_id
                };

                if ((vm.record.payroll_vertical_salary_scale_id > 0) && (vm.record.payroll_vertical_salary_scale_id > 0))
                    return;
                else if (((ladder == 'vertical') && (vm.record.payroll_horizontal_salary_scale_id > 0)) ||
                    ((ladder == 'horizontal') && (vm.record.payroll_vertical_salary_scale_id > 0)) ||
                    (ladder == 'all')) {

                    axios.post('/payroll/get-salary-scales', field).then(response => {
                        if (typeof(response.data) !== "undefined") {
                            if (vm.payroll_salary_tabulator_type == 'horizontal') {
                                vm.payroll_horizontal_salary_scales = response.data;
                            } else if (vm.payroll_salary_tabulator_type == 'vertical') {
                                vm.payroll_vertical_salary_scales = response.data;
                            } else if (ladder == 'horizontal') {
                                vm.payroll_horizontal_salary_scale_id = '';
                                vm.payroll_horizontal_salary_scales   = response.data;
                            } else if (ladder == 'vertical') {
                                vm.payroll_vertical_salary_scale_id = '';
                                vm.payroll_vertical_salary_scales   = response.data;
                            } else {
                                vm.payroll_horizontal_salary_scales = response.data;
                                vm.payroll_vertical_salary_scales   = response.data;
                            }
                        }
                    }).catch(error => {
                        if (typeof(error.response) !== "undefined") {
                            if (error.response.status == 403) {
                                vm.showMessage(
                                    'custom', 'Acceso Denegado', 'danger', 'screen-error', error.response.data.message
                                );
                            }
                            else {
                                vm.logs('modules/Payroll/Resources/assets/js/_all.js', 343, error, 'getPayrollSalaryScales');
                            }
                        }
                    });
                }
            },
		}
	};
</script>
