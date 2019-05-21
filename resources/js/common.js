$(document).ready(function() {
    if ($('.row-delete-img').length) {
        //si el atributo src de la imagen contiene la cadena no-image entonces no mostrar el enlace de eliminación, 
        //de lo contrario mostrarlo
        //if ($('.row-delete-img').closest('.form-group').find('img').attr('src') === "")
    }
});

/**
 * Función que permite cargar una imagen en el servidor
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
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
                logs('custom.js', 46, error, 'uploadImage');
            });
        }
    }).catch(error => {
        logs('custom.js', 50, error, 'uploadImage');
    });
}

var deleteImage = function(id) {
    if (id) {
        // Determinar si el valor es un arreglo de ids. Ej. 1,2,3,4,5,etc
        console.log(id);
        axios.delete(`/upload-image/${id}`).then(response => {

        }).catch(error => {
            console.log(error);
        });
    }
}