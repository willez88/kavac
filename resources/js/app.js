/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts a compilar por la aplicación
*/

/** Requerimiento del paquete bootstrap 4 para el diseño de la aplicación */
require('./bootstrap');
require('./loading-message');

/** @type {object} Requerimiento del paquete vue para la reactividad de la aplicación */
window.Vue = require('vue');

/** @type {Date} Año de ejecución */
window.execution_year = new Date().getFullYear();

if (window.auth) {
    /** Busca el año de ejecución solo cuando el usuario se encuentra autenticado */
    axios.get('/get-execution-year', {}).then(response => {
        if (response.data.result) {
            window.execution_year = response.data.year;
        }
    }).catch(error => {
        var err = error.toJSON();
        var p = {
            view: 'app',
            line: 25,
            code: error.response.status,
            type: error.response.statusText,
            message: err.message,
            url: error.response.config.url,
            method: error.response.config.method
        };
        if (window.debug) {
            console.error("Se ha generado un error con la siguiente información:", p);
            console.trace();
        }
    });
}
Vue.use(window.execution_year);

/**
 * Componente genérico para el uso de botones en formularios de ventanas modales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('modal-form-buttons', () => import(
    /* webpackChunkName: "modal-form-buttons" */
    './components/Shared/ButtonsFormModalComponent'
));

/**
 * Componente genérico para la gestión de imágenes
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('image-management', () => import(
    /* webpackChunkName: "image-management" */
    './components/Shared/ImageManagementComponent.vue'
));

/**
 * Componente para mostrar un listado con todas las notificaciones del usuario
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('users', () => import(
    /* webpackChunkName: "users" */
    './components/Shared/UsersComponent.vue'
));

/**
 * Componente para la configuración de permisos asociados a roles de usuarios
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('roles-permissions', () => import(
    /* webpackChunkName: "vue-tables-2" */
    './components/Shared/RolesAndPermissionsComponent.vue'
));

/**
 * Componente para la gestión de documentos a requerir
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('required-documents', () => import(
    /* webpackChunkName: "required-documents" */
    './components/Shared/RequiredDocumentsComponent.vue'
));

/**
 * Componente para la gestión de números telefónicos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('phones', () => import(
    /* webpackChunkName: "phones" */
    './components/Shared/PhonesComponent.vue'
));

/**
 * Componente genérico para mostrar motones de limpiar, cancelar o guardar registros cuando la altura del
 * formulario es muy alta
 *
 * @param string route_list Ruta que muestra el listado de registros cuando se presiona el botón cancelar
 * @param string display    Indica si los botones se muestran en un display al hacer scroll o son estáticos para
 *                          colocarlos en el footer de un formulario
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('buttonsDisplay', () => import(
    /* webpackChunkName: "buttons-form-display" */
    './components/Shared/ButtonsFormDisplayComponent.vue'
));

/**
 * Componente genérico para la gestión de documentos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('document-management', () => import(
    /* webpackChunkName: "document-management" */
    './components/Shared/DocumentManagementComponent.vue'
));

/**
 * Componente genérico para el uso de listas desplegables con select2 y selects dependientes
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('select2', () => import(
    /* webpackChunkName: "selects" */
    './components/Shared/SelectsComponent.vue'
));

/**
 * Componente genérico para el uso de listas desplegables de selección multiple
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @param array     options         Arreglo de objetos con las opciones a cargar.
 *                                  Ej.: [{clave: clave, valor: valor}, ...]
 * @param string    track_by        Define el nombre de la clave por la cual se va a gestionar la información.
 * @param boolean   taggable        Define si se muestra la selección mediante tags o no (opcional).
 *                                  El valor por defecto es true.
 * @param string    id              Define el identificador del objeto (opcional).
 * @param boolean   preselect_first Define si se preselecciona el primero objeto del arreglo (opcional).
 *                                  El valor por defecto es false
 * @param boolean   preserve_search Define si se preserva el campo de búsqueda (opcional).
 *                                  El valor por defecto es true
 * @param boolean   hide_selected   Define si se ocultan los elementos seleccionados (opcional).
 *                                  El valor por defecto es true
 * @param boolean   clear_on_select Define si se limpia el texto al seleccionar un elemento (opcional).
 *                                  El valor por defecto es true
 * @param boolean   close_on_select Define si se cierra la lista de elementos al seleccionar uno de ellos (opcional).
 *                                  El valor por defecto es true
 *
 * @note
 * Ejemplo de uso:
 * <v-multiselect :options="[{key: 1, name: 'one'},{key: 2, name: 'two'},{key: 3, name: 'three'}]" track_by="key"
 * :hide_selected="false"></v-multiselect>
 */
Vue.component('v-multiselect', () => import(
    /* webpackChunkName: "multi-selects" */
    './components/Shared/MultiSelectsComponent.vue'
));

/**
 * Componente para la gestión de notificaciones en tiempo real
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('notifications', () => import(
    /* webpackChunkName: "dropdown-notifications" */
    './components/Notifications/DropdownNotificationsComponent.vue'
));

/**
 * Componente para mostrar un listado con todas las notificaciones del usuario
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('all-notifications', () => import(
    /* webpackChunkName: "all-notifications" */
    './components/Notifications/AllNotificationsComponent.vue'
));

/**
 * Componente para mostrar un listado de registros eliminados
 *
 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('restore-records', () => import(
    /* webpackChunkName: "restore-records" */
    './components/Admins/RestoreRecordsComponent.vue'
));

/**
 * Componente para mostrar un listado de registros a auditar
 *
 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('audit-records', () => import(
    /* webpackChunkName: "audit-records" */
    './components/Admins/AuditRecordsComponent.vue'
));

/**
 * Componente para la gestión de estados civiles
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('marital-status', () => import(
    /* webpackChunkName: "marital-status" */
    './components/Settings/MaritalStatusComponent.vue'
));

/**
 * Componente para la gestión de profesiones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('professions', () => import(
    /* webpackChunkName: "professions" */
    './components/Settings/ProfessionsComponent.vue'
));

/**
 * Componente para la gestión de tipos de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('institution-types', () => import(
    /* webpackChunkName: "institution-types" */
    './components/Settings/InstitutionTypesComponent.vue'
));

/**
 * Componente para la configuración y gestión de sectores de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('institution-sectors', () => import(
    /* webpackChunkName: "institution-sectors" */
    './components/Settings/InstitutionSectorsComponent.vue'
));


/**
 * Componente para la gestión de Países
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('countries', () => import(
    /* webpackChunkName: "countries" */
    './components/Settings/CountriesComponent.vue'
));

/**
 * Componente para la gestión de Estados
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('estates', () => import(
    /* webpackChunkName: "estates" */
    './components/Settings/EstatesComponent.vue'
));

/**
 * Componente para la gestión de Municipio
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('municipalities', () => import(
    /* webpackChunkName: "municipalities" */
    './components/Settings/MunicipalitiesComponent.vue'
));

/**
 * Componente para la gestión de Ciudades
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('cities', () => import(
    /* webpackChunkName: "cities" */
    './components/Settings/CitiesComponent.vue'
));

/**
 * Componente para la gestión de Parroquias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('parishes', () => import(
    /* webpackChunkName: "parishes" */
    './components/Settings/ParishesComponent.vue'
));

/**
 * Componente para la gestión de estatus de documentos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('document-status', () => import(
    /* webpackChunkName: "document-status" */
    './components/Settings/DocumentStatusComponent.vue'
));

/**
 * Componente para la gestión de impuestos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('taxes', () => import(
    /* webpackChunkName: "taxes" */
    './components/Settings/TaxesComponent.vue'
));

/**
 * Componente para la gestión de unidades tributarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('tax-units', () => import(
    /* webpackChunkName: "tax-units" */
    './components/Settings/TaxUnitsComponent.vue'
));

/**
 * Componente para la gestión de departamentos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('departments', () => import(
    /* webpackChunkName: "departments" */
    './components/Settings/DepartmentsComponent.vue'
));

/**
 * Componente para la gestión de monedas
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('currencies', () => import(
    /* webpackChunkName: "currencies" */
    './components/Settings/CurrenciesComponent.vue'
));

/**
* Componente para la gestión de unidades de medida
*
* @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
*/
Vue.component('measurement-units', () => import(
    /* webpackChunkName: "measurement-units" */
    './components/Settings/MeasurementUnitsComponent.vue'
));

/**
 * Componente para la gestión de deducciones
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('deductions', () => import(
    /* webpackChunkName: "deductions" */
    './components/Settings/DeductionsComponent.vue'
));

/**
 * Componente para la gestión de tipos de cambio
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('exchange-rates', () => import(
    /* webpackChunkName: "exchange-rates" */
    './components/Settings/ExchangeRatesComponent.vue'
));

/**
 * Componente para la gestión de módulos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('manage-modules', () => import(
    /* webpackChunkName: "modules" */
    './components/Settings/ModulesComponent.vue'
));
