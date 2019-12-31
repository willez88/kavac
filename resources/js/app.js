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
