/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts a compilar por la aplicación
*/

/** Requerimiento de elementos compartidos */
require('./shared');

/**
 * Componente para la gestión de estados civiles
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('marital-status', require('./components/MaritalStatusComponent.vue').default);

/**
 * Componente para la gestión de profesiones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('professions', require('./components/ProfessionsComponent.vue').default);

/**
 * Componente para la gestión de tipos de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('institution-types', require('./components/InstitutionTypesComponent.vue').default);

/**
 * Componente para la configuración y gestión de sectores de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('institution-sectors', require('./components/InstitutionSectorsComponent.vue').default);

/**
 * Componente para la gestión de Países
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('countries', require('./components/CountriesComponent.vue').default);

/**
 * Componente para la gestión de Estados
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('estates', require('./components/EstatesComponent.vue').default);

/**
 * Componente para la gestión de Municipio
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('municipalities', require('./components/MunicipalitiesComponent.vue').default);

/**
 * Componente para la gestión de Ciudades
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('cities', require('./components/CitiesComponent.vue').default);

/**
 * Componente para la gestión de Parroquias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('parishes', require('./components/ParishesComponent.vue').default);

/**
 * Componente para la gestión de estatus de documentos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('document-status', require('./components/DocumentStatusComponent.vue').default);

/**
 * Componente para la gestión de impuestos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('taxes', require('./components/TaxesComponent.vue').default);

/**
 * Componente para la gestión de unidades tributarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('tax-units', require('./components/TaxUnitsComponent.vue').default);

/**
 * Componente para la gestión de departamentos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('departments', require('./components/DepartmentsComponent.vue').default);

/**
 * Componente para la gestión de monedas
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('currencies', require('./components/CurrenciesComponent.vue').default);

/**
 * Componente para la gestión de documentos a requerir
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('required-documents', require('./components/RequiredDocumentsComponent.vue').default);

/**
 * Componente para la gestión de números telefónicos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('phones', require('./components/PhonesComponent.vue').default);

/**
* Componente para la gestión de unidades de medida
*
* @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
*/
Vue.component('measurement-units', require('./components/MeasurementUnitsComponent.vue').default);

/** Incorpora requerimientos de componentes de los módulos de la aplicación */
//require('./modules');

/** Incorpora requerimientos de mixins generales */
require('./mixins');

/** @type {object} Constante que crea el elemento Vue */
var app = new Vue({
    el: '#app',
});
