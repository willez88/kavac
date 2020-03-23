$(document).ready(function() {
    /** Tooltip para botón de eliminación de imagen */
    if ($('.img-delete').length) {
        $('.img-delete').attr({
            'title': 'Presione para eliminar esta imagen',
            'data-toggle': 'tooltip',
            'data-placement': 'left'
        });
        $('.img-delete').tooltip({delay: {hide:100}});
    }

    /** Evento que muestra u oculta el enlace para la eliminación de una imagen */
    $('.form-group input[type=file]').on('change', function() {
        if ($(this).closest('.form-group').find('.row-delete-img').length) {
            if ($(this).val()) {
                $(this).closest('.form-group').find('.row-delete-img').show();
            }
            else {
                $(this).closest('.form-group').find('.row-delete-img').hide();
            }
        }
    });

    /** Agrega un título a la tabla de registros */
    $(".VueTables").closest('.modal-table').prepend('<h6>Registros</h6>');
});

/**
 * Función que permite cargar una imagen en el servidor
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @param  {string}  form         Identificador del formulario que realiza la acción para registrar la imagen
 * @param  {string}  input_file   Identificador del campo de tipo file que ejecuta la acción
 * @param  {string}  input_hidden Identificador del campo al que se le asignara la imagen registrada
 * @param  {string}  img_tag      Nombre de la clase que mostrará la imagen cargada
 * @param  {string}  img_tag_mini Nombre de la clase que mostrará una miniatura de la imagen cargada. Opcional.
 * @param  {boolean} show_msg     Indica si se muestra o no un mensaje sobre la acción realizada
 */
var uploadSingleImage = function(form, input_file, input_hidden, img_tag, img_tag_mini, show_msg) {
    var show_msg = (typeof(show_msg) !== "undefined") ? show_msg : false;
    var img_tag_mini = (typeof(img_tag_mini) !== "undefined") ? img_tag_mini : '';
    var url = $(`#${form}`).attr('action');
    var formData = new FormData();
    var imageFile = document.querySelector(`#${input_file}`);
    formData.append("image", imageFile.files[0]);
    axios.post(url, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        var up = response.data;
        if (up.result) {
            if (show_msg) {
                $.gritter.add({
                    title: 'Exito!',
                    text: "La imagen se cargó correctamente",
                    class_name: 'growl-success',
                    image: "/images/screen-ok.png",
                    sticky: false,
                    time: 2500
                });
            }
            axios.get(`/get-image/${up.image_id}`).then(response => {
                var image = response.data.image;
                $(`.${img_tag}`).attr('src', `/${image.url}`);
                if (img_tag_mini) {
                    $(`.${img_tag_mini}`).attr('src', `/${image.url}`);
                }

                $(`#${input_hidden}`).val(image.id);

            }).catch(error => {
                logs('custom.js', 96, error, 'uploadImage');
            });
        }
    }).catch(error => {
        logs('custom.js', 100, error, 'uploadImage');
    });
}

/**
 * Función que permite eliminar una o varias imágenes
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @param  {string}  id           Identificador de la o las imágenes a eliminar
 * @param  {boolean} force_delete Indica si la eliminación es permanente. Opcional.
 */
var deleteImage = function(element_delete, id, no_image, force_delete) {
    var force_delete = (typeof(force_delete) !== undefined && force_delete)
                       ? {force_delete: force_delete} : {};
    if (id) {
        bootbox.confirm("Esta seguro de querer eliminar la imagen?", function(result) {
            if (result) {
                // Determinar si el valor es un arreglo de ids. Ej. 1,2,3,4,5,etc
                axios.delete(`/upload-image/${id}`, force_delete).then(response => {
                    if (!response.data.result) {
                        $.gritter.add({
                            title: 'Error!',
                            text: response.data.message,
                            class_name: 'growl-danger',
                            image: "/images/screen-error.png",
                            sticky: false,
                            time: 2500
                        });
                    }
                    else {
                        element_delete.closest('.form-group')
                                      .find('img').attr('src', `/images/no-image${no_image}.png`);
                    }
                }).catch(error => {
                    logs('common.js', 88, error, 'deleteImage');
                });
            }
        });
    }
}

/**
 * Función que permite mostrar una visita guiada sobre las funcionalidades de la aplicación
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @param   {array}     steps               Arreglo con los elementos a incorporar en la visita guiada de funcionalidades.
 *                                          Ejemplo. [
 *                                              {
 *                                                  element: "#elemento1",
 *                                                  intro: "Texto a mostrar en el mensaje",
 *                                                  position: "bottom|left|right|top" //Indicar solo una
 *                                              },
 *                                              {
 *                                                  element: "#elemento2",
 *                                                  intro: "Texto a mostrar en el mensaje",
 *                                                  position: "bottom|left|right|top" //Indicar solo una
 *                                              },
 *                                              ...
 *                                          ]
 * @param   {boolean}   disableInteraction  Determina si se tiene o no interacción con el elemento
 * @param   {boolean}   stepNumber          Define si se muestra o no el número del elemento en la visita guiada
 */
var startGuidedTour = function(steps, disableInteraction = true, stepNumber = true) {
    /**
     * Verifica si algún elemento del DOM no esta presente para filtrar los pasos a mostrar en el tour guiado solo
     * con elemento que se encuentren presentes
     */
    var steps = steps.filter(function(currentValue) {
        var value = currentValue.element.replace("#", "");
        var element = document.getElementById(value);
        if (typeof(element.position) === "undefined") {
            /**
             * Si no existe el atributo de posición se agrega por defecto para mostrar la información encima del
             * elemento
             */
            element.position = "top";
        }
        return  typeof(element) !== "undefined" && element !== null;
    });

    /** @type {object} Inicializa el objeto para el tour guiado */
    var intro = introJs();

    /** @type {object} Establece la configuración por defecto del tour guiado */
    intro.setOptions({
        steps: steps,
        nextLabel: 'Siguiente &rarr;',
        prevLabel: '&larr; Previo',
        skipLabel: 'Omitir',
        doneLabel: 'Finalizar',
        hintButtonLabel: 'Entendido',
        showStepNumbers: stepNumber,
        showProgress: true,
        disableInteraction: disableInteraction
    });

    /** Inicializa el proceso que muestra el tour guiado */
    intro.start();
}
