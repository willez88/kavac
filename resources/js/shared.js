/**
*--------------------------------------------------------------------------
* Shared Scripts
*--------------------------------------------------------------------------
*
* Scripts compartidos para ser requeridos por módulos externos al núcleo de la aplicación
*/

/** Requerimiento del paquete vue-table-2 para la representación de consultas en tablas con vue */
import {ServerTable, ClientTable, Event} from 'vue-tables-2';

Vue.use(ClientTable);

/** Requerimiento del paquete pretty-checkbox-vue para checkbox y radio inputs personalizados */
import PrettyCheckbox from 'pretty-checkbox-vue';

Vue.use(PrettyCheckbox);

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
Vue.component('v-multiselect', require('./components/MultiSelectsComponent.vue').default);

/**
 * Componente genérico para el uso de listas desplegables con select2 y selects dependientes
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('select2', require('./components/SelectsComponent.vue').default);

/**
 * Componente genérico para el uso de botones en formularios de ventanas modales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('modal-form-buttons', require('./components/ButtonsFormModalComponent').default);

/**
 * Componente genérico para la gestión de imágenes
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('image-management', require('./components/ImageManagementComponent.vue').default);

/**
 * Componente genérico para la gestión de documentos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('document-management', require('./components/DocumentManagementComponent.vue').default);

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
Vue.component('buttonsDisplay', require('./components/ButtonsFormDisplayComponent.vue').default);

/**
 * Componente para la gestión de números telefónicos
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('phones', require('./components/PhonesComponent.vue').default);

/**
 * Componente para la gestión de documentos a requerir
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('required-documents', require('./components/RequiredDocumentsComponent.vue').default);

/**
 * Componente para la configuración de permisos asociados a roles de usuarios
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('roles-permissions', require('./components/RolesAndPermissionsComponent.vue').default);

/**
 * Componente para la gestión de usuarios del sistema
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve / roldandvg@gmail.com)
 */
Vue.component('users', require('./components/UsersComponent.vue').default);


Vue.component('notifications', require('./components/NotificationsComponent.vue').default);
