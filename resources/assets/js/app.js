
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/** Marital status management component */
Vue.component('marital-status', require('./components/MaritalStatusComponent.vue'));

/** Professions management component */
Vue.component('professions', require('./components/ProfessionsComponent.vue'));

/** Institution Types management component */
Vue.component('institution-types', require('./components/InstitutionTypesComponent.vue'));

/** Institution Sectors management component */
Vue.component('institution-sectors', require('./components/InstitutionSectorsComponent.vue'));

/** Countries management component */
Vue.component('countries', require('./components/CountriesComponent.vue'));

const app = new Vue({
    el: '#app'
});
