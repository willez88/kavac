/** Variable que construye la función que muestra u oculta el mensaje de espera */
var waiting;
waiting = waiting || (function() {
    var loadingMessage = $("#modal-loading");
    return {
        showLoadingMessage: function() {
            loadingMessage.modal();
        },
        hideLoadingMessage: function(e) {
            loadingMessage.on('shown.bs.modal', function (e) {
                loadingMessage.modal('hide');
            });
        }
    }
})();

/** Evento que muestra el mensaje de espera cuando una petición AJAX es enviada */
/*$(document).ajaxSend(function(event, request, settings) {
    waiting.showLoadingMessage();
});*/

/** Evento que oculta el mensaje de espera cuando una petición AJAX fue completada */
/*$(document).ajaxComplete(function(event, request, settings) {
    waiting.hideLoadingMessage();
});*/

/** Evento que muestra el mensaje de espera cuando la aplicación carga una página */
//waiting.showLoadingMessage();

/** Evento que oculta el mensaje de espera cuando una página ha sido cargada por completo */
/*$(document).ready(function() {
    waiting.hideLoadingMessage();
});*/

/** Evento que oculta el mensaje de espera cuando una página ha sido cargada por completo */
/*document.onreadystatechange = () => {
    if (document.readyState == "complete") {
        waiting.hideLoadingMessage();
    }
}*/

/*$(window).on('load', function () {
    //$("#modal-loading").fadeIn("slow");
    $('.preloader').fadeOut(1000);
});*/
