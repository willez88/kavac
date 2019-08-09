/**
 * Componente para la configuración de categorias de origen para asientos contables
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-setting-category', require('./components/setting/AccountingSettingCategoryComponent.vue').default);

/**
 * Componente para el CRUD en ventana modal de cuentas patrimoniales
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-setting-account', require('./components/setting/AccountingSettingAccountComponent.vue').default);

/**
 * Componente para Listar cuentas patrimoniales
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-accounts-list', require('./components/accounts/AccountingAccountsListComponent.vue').default);

/**
 * Componente para la creación y edición de cuentas patrimoniales
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-create-edit-form', require('./components/accounts/AccountingCreateEditFormComponent.vue').default);

/**
 * Componente con el formulario para importar cuentas patrimoniales desde un excel
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-import-form', require('./components/accounts/AccountingAccountImportFormComponent.vue').default);


/**
 * Componente para la consulta de los registros del convertidor de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-converter-index', require('./components/account_converter/AccountingIndexComponent.vue').default);

/**
 * Componente para la creación de conversión de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-converter-create', require('./components/account_converter/AccountingCreateConvertionsComponent.vue').default);

/**
 * Componente para la edición de una conversión de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-converter-edit', require('./components/account_converter/AccountingEditConvertionComponent.vue').default);

/**
 * Componente para la consulta de asientos contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat', require('./components/seating/AccountingSeatComponent.vue').default);

/**
 * Componente para cargar la tabla de asientos contables
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-listing', require('./components/seating/AccountingSeatListingComponent.vue').default);

/**
 * Componente para la creación de asientos contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-create', require('./components/seating/AccountingSeatEditCreateComponent.vue').default);

/**
 * Componente para cargar la tabla de cuentas patrimoniales para el asiento contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-create-account', require('./components/seating/AccountingAccountsInSeatingComponent.vue').default);

/**
 * Componente index para el reporte de balance de comprobación
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-checkup-balance', require('./components/reports/index-CheckupBalanceComponent.vue').default);

/**
 * Componente index para el reporte del libro diario
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-diary-book', require('./components/reports/index-diaryBookComponent.vue').default);

/**
 * Componente index para el reporte del Mayor Analítico
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-analytical-major', require('./components/reports/index-AnalyticalMajorComponent.vue').default);

/**
 * Componente index para el reporte del Mayor Analítico
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-auxiliary-book', require('./components/reports/index-AuxiliaryBookComponent.vue').default);

/**
 * Componente index para el reporte de Balance General y reporte de satdo de resultados
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-balance-sheet-state-of-results', require('./components/reports/index-balanceSheet_and_stateOfResultsComponent.vue').default);

/**
 * Componente index para el reporte de Balance General y reporte de satdo de resultados
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('dashboard-accounting-info', require('./components/dashboard/index-Component.vue').default);

/**
 * Componente index para el reporte de Balance General y reporte de satdo de resultados
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('dashboard-accounting-report-histories', require('./components/dashboard/report-histories-Component.vue').default);


/**
* Evento global Bus del modulo de Contabilidad
*/
window.EventBus = new Vue;

/**
 * Opciones de configuración global del módulo de contabilidad
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.mixin({
	data() {
		return {
			errors:[],
			months:[
				{id:1, text:'Enero'},
				{id:2, text:'Febrero'},
				{id:3, text:'Marzo'},
				{id:4, text:'Abril'},
				{id:5, text:'Mayo'},
				{id:6, text:'Junio'},
				{id:7, text:'Julio'},
				{id:8, text:'Agosto'},
				{id:9, text:'Septiembre'},
				{id:10, text:'Octubre'},
				{id:11, text:'Noviembre'},
				{id:12, text:'Diciembre'}
			],
			years:[],
			year_init:new Date().getFullYear(),
			year_end:new Date().getFullYear(),
			month_init:1,
			month_end:12,
		}
	},
	computed:{
		existErrors:function(){
			return (this.errors.length > 0);
		}
	},
	methods:{
		/**
		* Crea un array con los años desde el dado hasta el actual
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @param  {integer} year_old fecha del año de inicio
		* @param  {boolean} optionExtra bandera para determinar si agregar un registro extra al pricipio del array de los años
		*/
		CalculateOptionsYears:function(year_old, optionExtra = false){
			var date = new Date();
			if (optionExtra) {
				this.years.push({
					id:0,
					text:'Todos'
				});
				this.year_init = 0;
			}
			for (var year = date.getFullYear(); year >= year_old; year--) {
				this.years.push({
					id:year,
					text:year
				});
			}
		},

		/**
		* Abre una nueva ventana en el navegador
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @param  {string} url para la nueva ventana
		* @param  {string} type tipo de ventana que se desea abrir
		* @return {boolean} Devuelve falso si no se ha indicado alguna información requerida
		*/
		OpenPdf:function(url, type){
			window.open(url, type);
		},

		/**
		* Se aprueba el asiento contable
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		approve:function(index) {
			var url = 'http://'+window.location.host+'/accounting/seating/approve';
			var records = this.records;
			var confirmated = false;
			var index = index - 1;
			const vm = this;

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
							vm.reload = true;
						}).catch(error => {});
    				}
    			}
    		});

    		if (confirmated) {
    			this.records = records;
    			this.reload = true;
    		}
		},

		/**
		 * cambia el formato para la fecha de YYYY/mm/dd a dd/mm/YYYY
		 * 
		 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		 * @param  {string} date fecha en formato YYYY/mm/dd
		 * @return {string} f_date fecha en formato dd/mm/YYYY
		 */
		formatDate(date){
			var f_date = date.split('-')[2]+'/'+date.split('-')[1]+'/'+date.split('-')[0];
			return f_date;
		},

		/**
		* Despliega y oculta los tr de una tabla que tengas el nombre dado
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @return String con la cadena permitida
		*/
		displayDetails(id){
			if (!document.getElementById) return false;
			fila = document.getElementsByName('details_'+id);
			for (var i = 0; i < fila.length; i++) {
				if (fila[i].style.display != "none") {
				  fila[i].style.display = "none"; //ocultar fila 
				  this.minimized = true;
				  $('#i-'+id+'-show').css("display", "none");
				  $('#i-'+id+'-none').css("display", "");
				} else {
				  fila[i].style.display = ""; //mostrar fila 
				  this.minimized = false;
				  $('#i-'+id+'-show').css("display", "");
				  $('#i-'+id+'-none').css("display", "none");
				}
			}
		},

		/**
		* Solo permite escribir en los input los caracteres establecidos
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @return {String} con la cadena permitida
		*/
		onlyNumbers(string, filter = null){
			var out = '';

			/** Caracteres validos por defecto */
			var dafaultFilter = '1234567890';
			if(filter != null){
				dafaultFilter = filter;
			}
			
		    /** Recorrer el texto y verificar si el caracter se encuentra en la lista de validos  */
		    for (var i=0; i<string.length; i++)
		       if (dafaultFilter.indexOf(string.charAt(i)) != -1) 
		             //Se añaden a la salida los caracteres validos
			     out += string.charAt(i);
			
		    /** Retornar valor filtrado */
		    return out;
		}
	}
});