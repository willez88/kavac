/**
*--------------------------------------------------------------------------
* Shared Scripts
*--------------------------------------------------------------------------
*
* Scripts compartidos para ser requeridos por módulos externos al núcleo de la aplicación
*/

/** Requerimiento del paquete vue-table-2 para la representación de consultas en tablas con vue */
import {ServerTable, ClientTable, Event} from 'vue-tables-2';
/** Establece el uso del plugin ClientTable */
Vue.use(ClientTable);
/** Establece el uso del plugin ServerTable */
Vue.use(ServerTable);

/** Requerimiento del paquete pretty-checkbox-vue para checkbox y radio inputs personalizados */
import PrettyCheckbox from 'pretty-checkbox-vue';
/** Establece el uso del plugin PrettyCheckbox */
Vue.use(PrettyCheckbox);

/** Requerimiento del paquete CKEditor para ser implementado en Vuejs */
import CKEditor from '@ckeditor/ckeditor5-vue2';
/** Establece el uso del plugin CKEditor */
Vue.use(CKEditor);
