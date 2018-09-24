
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    /** Required for Bootstrap 4 */
    window.Popper = require('popper.js').default;
    require('bootstrap');
    /** Required for file input uploads */
    require('bootstrap-fileinput');
    require('bootstrap-fileinput/js/locales/es');
    require('bootstrap-fileinput/themes/fa/theme');
    /** Override fileinput default icon fonts to FontAwesome and locale */
    $('input[type=file]').fileinput({theme: 'fa', language: 'es'});
    /** JQuery.Complexify required for validate strong password */
    require('jquery.complexify/jquery.complexify.banlist');
    require('jquery.complexify');
    /** Required for select list element */
    require('select2');
    /** Requerido para el uso del componente vue-tables-2 */
    require('vue-tables-2');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });
