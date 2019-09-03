/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts a compilar por la aplicación
*/

/** Requerimiento del paquete bootstrap 4 para el diseño de la aplicación */
require('./bootstrap');
//require('./loading-message');

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
        console.log(error);
    });
}
Vue.use(window.execution_year);

/** Requerimiento de elementos compartidos */
require('./shared');

/** Incorpora requerimientos de componentes de los módulos de la aplicación */
//require('./modules');

/** Incorpora requerimientos de mixins generales */
require('./mixins');
