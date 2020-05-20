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
