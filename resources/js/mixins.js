//import moment from 'moment';
window.moment = require('moment');
window.Chart = require('chart.js');

/** Import del editor clásico de CKEditor */
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
/** Import para traducción de CKEditor al español */
import '@ckeditor/ckeditor5-build-classic/build/translations/es';

/** Import del paquete inputmask para uso de mascara en campos de texto con vue */
import Inputmask from "inputmask";

/** Configuración de la directiva input-mask para uso de mascara en campos de texto de los componentes vuejs */
Vue.directive('input-mask', {
	bind: function(el) {
		new Inputmask().mask(el);
	},
});

/** Directiva que limita la escritura a solo digitos */
Vue.directive('is-digits', {
	bind: (el) => {
		el.addEventListener('keydown', (e) => {
			let key = e.keyCode;
			let tab = (key === 9), spacebar = (key === 32), backspace = (key === 8), alt = (key === 18),
				numeric = (key >= 48 && key <=57) || (key >= 96 && key <= 105), supr = (key === 46),
				ctrl = (key === 17), ctrlA = (key === 65), ini = (key === 36), end = (key === 35);
			if (numeric || spacebar || tab || ini || end || backspace || alt || supr) {
				return;
			}
			else {
				e.preventDefault();
			}
		});
	}
});

/** Directiva que limita la escritura a solo números y el signo "." */
Vue.directive('is-numeric', {
	bind: (el) => {
		el.addEventListener('keydown', (e) => {
			let key = e.keyCode;
			let tab = (key === 9), backspace = (key === 8), alt = (key === 18),
				numeric = (key >= 48 && key <=57) || (key >= 96 && key <= 105), supr = (key === 46),
				ctrl = (key === 17), ctrlA = (key === 65), ini = (key === 36), end = (key === 35),
				dot = (key === 190 && !el.value.includes("."));

			if (numeric || tab || ini || end || backspace || alt || supr || dot) {
				return;
			}
			else {
				e.preventDefault();
			}
		});
	}
});

/** Directiva que limita la escritura a solo carácteres alfabéticos, los signos "." y "," */
Vue.directive('is-text', {
	bind: (el) => {
		el.addEventListener('keydown', (e) => {
			let key = e.keyCode;
			let tab = (key === 9), backspace = (key === 8), alt = (key === 18), spacebar = (key === 32),
				alphabet = (key >= 65 && key <= 90), supr = (key === 46),
				ctrl = (key === 17), ctrlA = (key === 65), ini = (key === 36), end = (key === 35),
				dot = (key === 190), caps = (key === 20), shift = (key === 16), comma = (key === 188),
				special = (key === 59 || key === 56 || key === 57),
				hyphen = (key === 109 || key === 173);

			if (
				alphabet || tab || ini || end || backspace || alt || supr || dot || caps || shift || spacebar ||
				special || comma || hyphen
			) {
				return;
			}
			else {
				e.preventDefault();
			}
		});
	}
});

Vue.directive('has-tooltip', {
    bind: (el, binding) => {
        $(el).tooltip({
            title: $(el).attr('title') || $(el).data('original-title'),
            placement: binding.arg || 'top',
            trigger: 'hover'
        });
    }
});

/**
 * Opciones de configuración global para utilizar en todos los componentes vuejs de la aplicación
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @param  {object} methods Métodos generales a implementar en CRUDS
 */
Vue.mixin({
	data() {
		return {
			/** @type {Boolean} Establece si se esta o no cargando una petición del sistema */
			loading: true,
			/** @type {Object} Objeto que contiene los atributos y métodos para obtener traducciones del sistema  */
			//i18n: Lang,
			/** @type {Object} Objeto que contiene datos a gestionar para el bloque de pantalla por inactividad */
			lockscreen: {
				time: 0, //Tiempo de inactividad establecido para el bloqueo de la pantalla
				lock: true, //Indica si se bloquea o no la pantalla por inactividad
				timer_timeout: 0
			},
			/**
			 * Opciones generales a implementar en tablas
			 * @type {JSON}
			 */
			table_options: {
				pagination: { edge: true },
				//filterByColumn: true,
				highlightMatches: true,
				texts: {
					filter: "Buscar:",
					filterBy: 'Buscar por {column}',
					//count:'Página {page}',
					count: ' ',
					first: 'PRIMERO',
					last: 'ÚLTIMO',
					limit: 'Registros',
					//page: 'Página:',
					noResults: 'No existen registros',
				},
				sortIcon: {
					is: 'fa-sort cursor-pointer',
					base: 'fa',
					up: 'fa-sort-up cursor-pointer',
					down: 'fa-sort-down cursor-pointer'
				},
			},
			ckeditor: {
				editor: ClassicEditor,
				editorConfig: {
					toolbar: [
						'heading', '|',
						'bold', 'italic', 'blockQuote', 'link',
						'numberedList', 'bulletedList', '|',
						'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
						'undo', 'redo'
					],
					language: window.currentLocale
				}
			}
		}
	},
	props: {
		route_list: {
			type: String,
			required: false,
			default: ''
		},
		route_create: {
			type: String,
			required: false,
			default: ''
		},
		route_edit: {
			type: String,
			required: false,
			default: ''
		},
		route_update: {
			type: String,
			required: false,
			default: ''
		},
		route_delete: {
			type: String,
			required: false,
			default: ''
		},
		route_show: {
			type: String,
			required: false,
			default: ''
		},
        helpFile: {
            type: String,
            required: false,
            default: null
        }
	},
	watch: {
		/**
		 * Método que permite mostrar el mensaje de espera al usuario cuando cambia el estatus de la variable "loading"
		 *
		 * @method     loading
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		loading: function() {
			let vm = this;
			if (!vm.loading) {
				$('.preloader').fadeOut(2000);
			}
			else {
				$('.preloader').show();
			}
		},
		record: {
			deep: true,
			handler: function(newValue, oldValue) {

			}
		},
	},
	methods: {
		/**
		 * Registro de eventos del sistema
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string}  v  Vista
		 * @param  {integer} l  Línea
		 * @param  {object}  e  Objeto con datos del error
		 * @param  {string}  f  Función. Opcional
		 */
		logs: function(v, l, e, f) {
			let vm = this;
			var f = (typeof(f) !== "undefined") ? f : false;
			var err = e.toJSON();
			var p = {
				view: v,
				line: l,
				code: e.response.status,
				type: e.response.statusText,
				message: err.message,
				url: e.response.config.url,
				method: e.response.config.method,
				func: null
			};
			if (f) {
				p.func = f;
			}

			if (window.debug) {
				console.error("Se ha generado un error con la siguiente información:", p);
				console.trace();
			}
			else {
				axios.post(window.log_url, {
					view: p.view,
					line: p.line,
					code: p.code,
					type: p.type,
					message: p.message,
					url: p.url,
					method: p.method,
					func: p.func
				});
			}
		},
		/**
		 * Redirecciona a una url esecífica si fue suministrada
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} url URL a redireccionar.
		 */
		redirect_back: function(url) {
			location.href = url;
		},
		/**
		 * Ejecuta el evento click del campo de tipo archivo al cual cargar información
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param {string} input_id Identificador del campo de tipo archivo
		 */
		setFile(input_id) {
			$(`#${input_id}`).click();
		},
		/**
		 * Método que permite dar formato a una fecha
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} value  Fecha ser formateada
		 * @param  {string} format Formato de la fecha
		 *
		 * @return {string}       Fecha con el formato establecido
		 */
		format_date: function(value, format = 'DD/MM/YYYY') {
			return moment(String(value)).format(format);
		},
		/**
		 * Método que permite dar formato con marca de tiempo a una fecha
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} value Fecha ser formateada
		 *
		 * @return {string}       Fecha con el formato establecido
		 */
		format_timestamp: function(value) {
			return moment(String(value)).format('DD/MM/YYYY hh:mm:ss');
		},
		/**
		 * Método que calcula la diferencia entre dos fechas con marca de tiempo
		 *
		 * @method     diff_datetimes
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param      {string}  dateThen    Fecha a comparar para obtener la diferencia con respecto a la fecha actual
		 *
		 * @return     {[type]}  Objeto con información de la diferencia obtenida entre las dos fechas
		 */
		diff_datetimes: function(dateThen) {
			var now = moment().format("YYYY-MM-DD HH:mm:ss");
			var ms = moment(dateThen,"YYYY-MM-DD HH:mm:ss").diff(moment(now,"YYYY-MM-DD HH:mm:ss"));
			var d = moment.duration(ms);
			return {
				years: d._data.years,
				months: d._data.months,
				days: d._data.days,
				hours: d._data.hours,
				minutes: d._data.minutes,
				seconds: d._data.seconds
			};
		},
		/**
		 * Agrega dias, meses o años a una fecha proporcionada
		 *
		 * @method    add_period
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param     {string}         current    Fecha actual
		 * @param     {integer}        number     Número de elementos a agregar
		 * @param     {string}         type       Tipo de elemento a agregar. Ej. days, months o years
		 * @param     {string}         format     Formato de fecha
		 *
		 * @return    {string}      Fecha del período agregado
		 */
		add_period: function(current, number, type, format = 'DD/MM/YYYY') {
			return moment(current).add(number, type).format(format);
		},
		/**
		 * Establece el día de inicio de una fecha dada
		 *
		 * @method    start_day
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param     {string}          date       Fecha de la cual identificar el día
		 * @param     {string}          format     Formato de fecha
		 * @param     {string}          startOf    Desde donde se va a establecer el día
		 * @param     {string|integer}  day        Día de inicio
		 *
		 * @return    {string}     Fecha del día a establecer
		 */
		start_day: function(date, format, startOf, day) {
			return moment(date, format).startOf(startOf).day(day);
		},
		/**
		 * Método que permite convertir elementos de medida y peso
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {float}  number Numero a convertir
		 * @param  {string} from   Unidad de medida o peso desde la cual se desea realizar la conversión
		 * @param  {string} to     Unidad de medida o peso a la cual se desea realizar la conversión
		 *
		 * @return {float}         Retorna el valor numérico despues de la conversión
		 */
		measure_converter: function(number, from, to) {
			var result = false;
			let measurements = [
				'mm', 'cm', 'mt', 'km', 'in', 'ft', 'px', 'em', 'rem', 'lt', 'kg', 'tn'
			];
			let factors = {
				mm: {cm: 0.1, mt: 0.001, ft: 0.00328084, in: 0.0393701, px: 3.779527559055},
				cm: {mm: 10, mt: 0.01, ft: 0.0328084, in: 0.393701, px: 37.79527559055},
				mt: {mm: 1000, cm: 100, km: 0.001, ft: 3.28084, in: 39.3701, px: 3779.527559055},
				km: {mt: 1000, cm: 100000, ft: 3280.84, in: 39370.1},
				in: {mt: 0.0254, cm: 2.54, mm: 25.4, ft: 0.0833333, px: 96},
				ft: {km: 0.0003048, mt: 0.3048, cm: 30.48, mm: 304.8, in: 12},
				px: {mm: 0.264583333, cm: 0.02645833333333, mt: 0.0002645833333333, em: 0.7528125},
				em: {px: 1.421348031496}
			};

			if (measurements.includes(from) && measurements.includes(to) && from !== to) {
				number = parseFloat(number * factors[from][to]);
				result = true;
			}
			return {result: result, number: number};
		},
		/**
		 * Inicializa todos los campos de formularios a un valor vacío
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		clearForm() {
			let vm = this;
			if (typeof(vm.record) !== "undefined") {
				for (var index in vm.record) {
					vm.record[index] = '';
				}
			}
		},
		/**
		 * Inicializa los registros base del formulario
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param {string}  url       Ruta que obtiene los datos a ser mostrado en listados
		 * @param {string}  modal_id  Identificador del modal a mostrar con la información solicitada
         */
		initRecords(url, modal_id) {
			this.errors = [];
			this.reset();
			const vm = this;
			url = (!url.includes('http://') || !url.includes('http://'))
				  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

			axios.get(url).then(response => {
				if (typeof(response.data.records) !== "undefined") {
					vm.records = response.data.records;
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
		/**
		 * Método que obtiene los registros a mostrar
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} url Ruta que obtiene todos los registros solicitados
		 */
		readRecords(url) {
			const vm = this;
			vm.loading = true;
			url = (!url.includes('http://') || !url.includes('http://'))
				  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

			axios.get(url).then(response => {
				if (typeof(response.data.records) !== "undefined") {
					vm.records = response.data.records;
				}
				vm.loading = false;
			}).catch(error => {
				vm.logs('mixins.js', 285, error, 'readRecords');
			});
		},
		/**
		 * Método que permite mostrar una ventana emergente con la información registrada
		 * y la nueva a registrar
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param {string} modal_id Identificador de la ventana modal
		 * @param {string} url      Ruta para acceder a los datos solicitados
		 * @param {object} event    Objeto que gestiona los eventos
		 */
		async addRecord(modal_id, url, event) {
			event.preventDefault();
            this.loading = true;
            await this.initRecords(url, modal_id);
            this.loading = false;
		},
		/**
		 * Método que permite crear o actualizar un registro
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} url    Ruta de la acción a ejecutar para la creación o actualización de datos
		 * @param  {string} list   Condición para establecer si se cargan datos en un listado de tabla.
		 *                         El valor por defecto es verdadero.
		 * @param  {string} reset  Condición que evalúa si se inicializan datos del formulario.
		 *                         El valor por defecto es verdadero.
		 */
		createRecord(url, list = true, reset = true) {
			const vm = this;
			url = (!url.includes('http://') || !url.includes('http://'))
				  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

			if (vm.record.id) {
				vm.updateRecord(url);
			}
			else {
				vm.loading = true;
				var fields = {};
				for (var index in vm.record) {
					fields[index] = vm.record[index];
				}
				axios.post(url, fields).then(response => {
					if (typeof(response.data.redirect) !== "undefined") {
						location.href = response.data.redirect;
					}
					else {
						vm.errors = [];
						if (reset) {
							vm.reset();
						}
						if (list) {
							vm.readRecords(url);
						}
						vm.loading = false;
						vm.showMessage('store');
					}

				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}

					vm.loading = false;
				});
			}

		},
		/**
		 * Redirecciona al formulario de actualización de datos
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador del registro a actualizar
		 */
		editForm(id) {
			location.href = (this.route_edit.indexOf("{id}") >= 0)
							? this.route_edit.replace("{id}", id)
							: this.route_edit + '/' + id;
		},
		/**
		 * Método que carga el formulario con los datos a modificar
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} index Identificador del registro a ser modificado
		 * @param {object} event   Objeto que gestiona los eventos
		 */
		initUpdate(id, event) {
			let vm = this;
			vm.errors = [];

			let recordEdit = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
				return rec.id === id;
			})[0])) || vm.reset();

			vm.record = recordEdit;

			/**
			 * Recorre todos los campos para determinar si existe un elemento booleano para, posteriormente,
			 * seleccionarlo en el formulario en el caso de que se encuentre activado en BD
			 */
			$.each(vm.record, function(el, value) {
				if ($("input[name=" + el + "]").hasClass('bootstrap-switch')) {
					/** verifica los elementos bootstrap-switch para seleccionar el que corresponda según los registros del sistema */
					$("input[name=" + el + "]").each(function() {
						if ($(this).val() === value) {
							$(this).bootstrapSwitch('state', value, true)
						}

					});
				}
				if (value === true || value === false) {
					$("input[name=" + el + "].bootstrap-switch").bootstrapSwitch('state', value, true);
				}
				/*if (el.substring(el.length - 3, el.length) === "_id") {
					$("#" + el + ".select2").val(value);
				}*/
			});

			event.preventDefault();
		},
		/**
		 * Método que permite actualizar información
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} url Ruta de la acci´on que modificará los datos
		 */
		updateRecord(url) {
			const vm = this;
			vm.loading = true;
			var fields = {};
			url = (!url.includes('http://') || !url.includes('http://'))
				  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

			for (var index in vm.record) {
				fields[index] = vm.record[index];
			}
			axios.patch(`${url}${(url.endsWith('/'))?'':'/'}${vm.record.id}`, fields).then(response => {
				if (typeof(response.data.redirect) !== "undefined") {
					location.href = response.data.redirect;
				}
				else {
					vm.readRecords(url);
					vm.reset();
					vm.loading = false;
					vm.showMessage('update');
				}

			}).catch(error => {
				vm.errors = [];

				if (typeof(error.response) !="undefined") {
					for (var index in error.response.data.errors) {
						if (error.response.data.errors[index]) {
							vm.errors.push(error.response.data.errors[index][0]);
						}
					}
				}
				vm.loading = false;
			});
		},
		/**
		 * Método que muestra datos de un registro seleccionado
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador del registro a mostrar
		 */
		showRecord(id) {
			if (typeof(this.route_show) !== "undefined" && this.route_show) {
				if (this.route_show.indexOf("{id}") >= 0) {
					location.href = this.route_show.replace("{id}", id);
				}
				else {
					location.href = this.route_show + '/' + id;
				}
			}
		},
		/**
		 * Método para la eliminación de registros
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id    ID del Elemento seleccionado para su eliminación
		 * @param  {string}  url   Ruta que ejecuta la acción para eliminar un registro
		 */
		deleteRecord(id, url) {
			const vm = this;
			/** @type {string} URL que atiende la petición de eliminación del registro */
			var url = (url)?url:vm.route_delete;
			url = (!url.includes('http://') || !url.includes('http://'))
				  ? `${window.app_url}${(url.startsWith('/'))?'':'/'}${url}` : url;

			bootbox.confirm({
				title: "¿Eliminar registro?",
				message: "¿Esta seguro de eliminar este registro?",
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
						/** @type {object} Objeto con los datos del registro a eliminar */
						let recordDelete = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
							return rec.id === id;
						})[0]));

						axios.delete(`${url}${url.endsWith('/')?'':'/'}${recordDelete.id}`).then(response => {
							if (typeof(response.data.error) !== "undefined") {
								/** Muestra un mensaje de error si sucede algún evento en la eliminación */
								vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
								return false;
							}
							/** @type {array} Arreglo de registros filtrado sin el elemento eliminado */
							vm.records = JSON.parse(JSON.stringify(vm.records.filter((rec) => {
								return rec.id !== id;
							})));
							vm.showMessage('destroy');
						}).catch(error => {
							vm.logs('mixins.js', 498, error, 'deleteRecord');
						});
					}
				}
			});
		},
		/**
		 * Método que muestra un mensaje al usuario sobre el resultado de una acción
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} type        Tipo de mensaje a mostrar
		 * @param  {string} msg_title   Título del mensaje (opcional)
		 * @param  {string} msg_class   Clase CSS a utilizar en el mensaje (opcional)
		 * @param  {string} msg_icon    Ícono a mostrar en el mensaje (opcional)
		 * @param  {string} custom_text Texto personalizado para el mensaje (opcional)
		 */
		showMessage(type, msg_title, msg_class, msg_icon, custom_text) {
			msg_title = (typeof(msg_title) == "undefined" || !msg_title)?'Éxito':msg_title;
			msg_class = (typeof(msg_class) == "undefined" || !msg_class)?'growl-success':'growl-'+msg_class;
			msg_icon = (typeof(msg_icon) == "undefined" || !msg_icon)?'screen-ok':msg_icon;
			custom_text = (typeof(custom_text)!=="undefined")?custom_text:'';

			var msg_text;
			if (type=='store') {
				msg_text = 'Registro almacenado con éxito';
			}
			else if (type=='update') {
				msg_text = 'Registro actualizado con éxito';
			}
			else if (type=='destroy') {
				msg_text = 'Registro eliminado con éxito';
			}
			else if (type=='custom') {
				msg_text = custom_text;
			}

			/** @type {object} Muestra el correspondiente mensaje al usuario */
			$.gritter.add({
				title: msg_title,
				text: msg_text,
				class_name: msg_class,
				image: `${window.app_url}/images/${msg_icon}.png`,
				sticky: false,
				time: 3500
			});
		},
		/**
		 * Método que obtiene los países registrados
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		getCountries() {
			const vm = this;
			axios.get('/get-countries').then(response => {
				vm.countries = response.data;
			});
		},
		/**
		 * Obtiene los Estados del Pais seleccionado
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		getEstates() {
			const vm = this;
			vm.estates = [];
			if (vm.record.country_id) {
				axios.get(`/get-estates/${vm.record.country_id}`).then(response => {
					vm.estates = response.data;
				});
			}
		},
		/**
		 * Obtiene los Municipios del Estado seleccionado
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		getMunicipalities() {
			const vm = this;
			vm.municipalities = [];
			if (vm.record.estate_id) {
				axios.get(`/get-municipalities/${vm.record.estate_id}`).then(response => {
					vm.municipalities = response.data;
				});
			}
		},
		/**
		 * Obtiene los Municipios del Estado seleccionado
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		getCities() {
			const vm = this;
			vm.cities = [];
			if (vm.record.estate_id) {
				axios.get(`/get-cities/${vm.record.estate_id}`).then(response => {
					vm.cities = response.data;
				});
			}
		},
		/**
		 * Obtiene las parroquias del municipio seleccionado
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getParishes() {
			const vm = this;
			vm.parishes = [];
			if (vm.record.municipality_id) {
				axios.get(`/get-parishes/${vm.record.municipality_id}`).then(response => {
					vm.parishes = response.data;
				});
			}
		},
		/**
		 * Obtiene un arreglo con las organizaciones registradas
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador de la organización a buscar, este parámetro es opcional
		 */
		getInstitutions(id) {
			const vm = this;
			vm.institutions = [];
			var institution_id = (typeof(id)!=="undefined")?'/'+id:'';
			axios.get(`/get-institutions${institution_id}`).then(response => {
				vm.institutions = response.data;
			});
		},
		/**
		 * Obtiene un arreglo con las monedas registradas
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador de la moneda a buscar, este parámetro es opcional
		 */
		getCurrencies(id) {
			const vm = this;
			var currency_id = (typeof(id)!=="undefined")?'/'+id:'';
			vm.currencies = [];
			axios.get(`/get-currencies${currency_id}`).then(response => {
				vm.currencies = response.data;
			});
		},
		/**
		 * Obtiene los departamentos o unidades de la organización
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador del departamento a filtrar (opcional)
		 */
		getDepartments(id) {
			let vm = this;
			vm.departments = [];
			if (typeof(vm.record.institution_id) !== "undefined" && vm.record.institution_id !== '') {
				axios.get(`/get-departments/${vm.record.institution_id}`).then(response => {
					/** Obtiene los departamentos */
					vm.departments = (typeof(id) === "undefined" || !id)
									 ? response.data
									 : response.data.filter((department) => {
										return department.id === "" || department.id === id;
									 });
				});
			}
		},
		/**
		 * Obtiene un arreglo con los estados civiles
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer} id Identificador del estado civil a filtrarm este campo es opcional
		 */
		getMaritalStatus(id) {
			const vm = this;
			vm.marital_status = [];
			var marital_status_id = (typeof(id)!=="undefined")?'/'+id:'';
			axios.get(`/get-marital-status${marital_status_id}`).then(response => {
				vm.marital_status = response.data;
			});
		},
		/**
		 * Obtiene un arreglo con las profesiones
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 *
		 * @param  {integer} id Identificador de la profesión a filtrar, este campo es opcional
		 */
		getProfessions(id) {
			const vm = this;
			vm.professions = [];
			var profession_id = (typeof(id)!=="undefined")?'/'+id:'';
			axios.get(`/get-professions${profession_id}`).then(response => {
				vm.professions = response.data;
			});
		},
		/**
		 * Agrega una nueva columna para el registro de número telefónicos
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		addPhone: function() {
			const vm = this;
			vm.record.phones.push({
				type: '',
				area_code: '',
				number: '',
				extension: ''
			});
			setTimeout(function(args) {
				$('.phone-row').each(function(index) {
					if (index === (vm.record.phones.length - 1)) {
						let select2 = $(this).find('.select2');
						select2.select2({});
						select2.attr({
							'title': 'Seleccione un registro de la lista',
							'data-toggle': 'tooltip'
						});
						select2.tooltip({ delay: { hide: 100 } });
						select2.on('shown.bs.tooltip', function() {
							setTimeout(function() {
								select2.tooltip('hide');
							}, 1500);
						});
						select2.on('change', (e) => {
							vm.record.phones[index].type = e.target.value;
						});
					}
				});
			}, 50);
		},
		/**
		 * Elimina la fila del elemento indicado
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {integer}      index Indice del elemento a eliminar
		 * @param  {object|array} el    Elemento del cual se va a eliminar un elemento
		 */
		removeRow: function(index, el) {
			el.splice(index, 1);
		},
		/**
		 * Gestiona el evento del elemento switch en radio y checkbox
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string} elName       Nombre del elemento switch
		 * @param  {string} model        Nombre del modelo al cual asignar el valor del switch
		 * @param  {string} other_model  Nombre de otro modelo al cual asignar el valor del switch
		 */
		switchHandler: function(elName, model, other_model) {
			/** Si no se ha indicado el modelo se asigna como valor por defecto el del nombre del elemento */
			var model = (typeof(model) !== "undefined") ? model: elName;
			/** Si se ha especificado otro modelo al cual asignar el valor */
			var other_model = (typeof(other_model) !== "undefined") ? other_model: null;
			let vm = this;
			$(`input[name=${elName}].bootstrap-switch`).on('switchChange.bootstrapSwitch', function() {
				var value = ($(this).val().toLowerCase() === "true")
							? true : (($(this).val().toLowerCase() === "false") ? false : $(this).val());
				/** Asigna el valor del elemento radio o checkbox seleccionado */
				if (other_model) {
					/** en caso de asignar el valor a otro objeto de modelo */
					other_model = ($(this).is(':checked')) ? value : '';
				}
				else {
					/** objeto de registros por defecto */
					vm.record[model] = ($(this).is(':checked')) ? value : '';
				}
			});
		},
		/**
		 * Agrega mensajes tooltip a elementos bootstrap switch
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @param  {string}  elName    Nombre del elemento
		 * @param  {string}  text      Texto a mostrar en el tooltip
		 * @param  {integer} delayHide Tiempo en milisegundos para ocultar la ventana tooltip
		 */
		switchTooltip: function(elName, text, delayHide) {
			var delayHide = (typeof(delayHide) !== "undefined") ? delayHide : 200;
			$(`input[name=${elName}]`).closest('.bootstrap-switch-wrapper').attr({
				'title': (typeof(text)!=="undefined")?text:$(this).data('original-title'),
				'data-toggle': 'tooltip'
			}).tooltip({
				trigger:"hover",
				delay: {hide: delayHide}
			});
		},
        initUIGuide: function(file) {
            let helpFile = (typeof file === 'string' || typeof file instanceof String) ? file : JSON.stringify(file);
            startGuidedTour(JSON.parse(helpFile));
        },
		/**
		 * Realiza las acciones necesarias para bloquear la pantalla del sistema por inactividad del usuario
		 *
		 * @method     lockScreen
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 *
		 * @return     {boolean}         Retorna falso si la pantalla ya esta bloqueada
		 */
		async lockScreen() {
			let vm = this;
			if (window.screen_locked) {
				$(document.body).addClass('modalBlur');
				$(".modal-lockscreen").modal('show');
				return false;
			}
			else {
				if (vm.lockscreen.time === 0) {
					/** @type {Object} Datos del usuario para el bloqueo de pantalla por inactividad */
					let response = await axios.get('/get-lockscreen-data');
					vm.lockscreen.lock = response.data.lock_screen;
					vm.lockscreen.time = response.data.time_lock;
				}

				if (vm.lockscreen.time > 0) {
					/** Bloquea la pantalla del sistema al no haber actividad por parte del usuario */
					vm.lockscreen.timer_timeout = setTimeout(function() {
						$(document.body).addClass('modalBlur');
						$(".modal-lockscreen").modal('show');
						window.screen_locked = true;
						axios.post('/set-lockscreen-data', {
							lock_screen: true
						}).catch(error => {
							console.warn(error);
						});
					}, vm.lockscreen.time * 60000);


					/** @type {Array} Eventos que determinan actividad del usuario en la aplicación */
					/*var activityEvents = [
						'mousedown', 'mousemove', 'keydown',
						'scroll'
					];*/

					/** Reinicia el contador para bloquear la pantalla si el usuario ha estado activo en la aplicación */
					/*activityEvents.forEach(function(eventName) {
						document.addEventListener(eventName, function() {
							console.log($(".modal-lockscreen").is(':visible'))
							if (!$(".modal-lockscreen").is(':visible')) {
								clearTimeout(vm.timer_timeout);
								window.screen_locked = false;
								vm.lockscreen.timer_timeout = setTimeout(function() {
									$(document.body).addClass('modalBlur');
									$(".modal-lockscreen").modal('show');
									window.screen_locked = true;
									axios.post('/set-lockscreen-data', {
										lock_screen: true
									}).catch(error => {
										console.warn(error);
									});
								}, vm.lockscreen.time * 60000);
							}
						}, true);
					});*/
				}
			}
		},
		/**
		 * Método que permite borrar los filtros de la consulta en las tablas
		 *
		 * @method    clearFilters
		 *
		 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 */
		clearFilters() {
			//this.$refs['table'].setFilter('');
		}
		/*loadRelationalSelect(parent_id, target_url) {
			var parent_id = (typeof(parent_id) !== "undefined")?parent_id:false;
			var target_url = (typeof(target_url) !== "undefined")?target_url:false;

			if (parent_id) {
				axios.get('/' + target_url + '/' + parent_id).then(response => {
					this.estates = response.data;
				});
			}
		}*/
	},
	async created() {
		await this.clearForm();
		this.loading = false;
        /** Ajustes de elementos de la tabla de VueTables */
        $('.VueTables__search__input').attr({
            'data-original-title': 'Filtrar resultados',
            'data-toggle': 'tooltip'
        });
        $('.VueTables__search__input').tooltip();
        $('.VueTables__limit-field').attr({
            'data-original-title': 'Cantidad de registros a mostrar por página',
            'data-toggle': 'tooltip'
        });
        $('.VueTables__limit-field').tooltip();
        $("[id^=VueTables__limit]").select2();
	},
	async mounted() {
		let vm = this;
		if ($('.modal-lockscreen').length > 0) {
			//vm.lockScreen();
			//$('.modal-lockscreen').on('hidden.bs.modal', function() {
				/** Reinicia el valor del campo de la contraseña */
				//$(".modal-lockscreen").find('#password').val('');
				//vm.lockScreen();
			//});
		}
		$('.modal').on('hidden.bs.modal', function() {
			//$("input[class^='VueTables__search']").val('');
			vm.clearFilters();
		});
		$('.modal').on('shown.bs.modal', function() {
			//vm.records = vm.data;
		});
	},
    updated: function() {
        const vm = this;
        vm.$nextTick(function() {
            $("input[type=radio]").each(function() {
                let title = $(this).attr('title') || $(this).data('original-title');
                $(this).closest('.bootstrap-switch-wrapper').attr({
                    'title': title,
                    'data-toggle': 'tooltip'
                }).tooltip({
                    trigger:"hover",
                    delay: {hide: 200}
                });
            });
        });
    }
});
