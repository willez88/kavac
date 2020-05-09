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

/** Requerimiento del paquete CKEditor para ser implementado en Vuejs */
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use(CKEditor);
