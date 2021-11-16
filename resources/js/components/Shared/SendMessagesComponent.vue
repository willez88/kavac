<template>
    <div class="modal fade" id="modalSendMessage" tabindex="-1" role="dialog" aria-labelledby="modalSendMessageTitle" 
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSendMessageTitle">Enviar Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group is-required">
                                <label>Para</label>
                                <input type="text" class="form-control" data-toggle="tooltip" v-model="record.toEmail"
                                       title="Indique la(s) cuenta(s) de correo electrónico a enviar el mensaje">
                            </div>
                            <div class="form-group is-required">
                                <ckeditor :editor="ckeditor.editor" id="description" data-toggle="tooltip"
                                  title="Indique una descripción para el compromiso" :config="ckeditor.editorConfig"
                                  class="form-control" name="description" tag-name="textarea" rows="3"
                                  v-model="record.message"></ckeditor>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    toEmail: '',
                    message: ''
                }
            }
        }
    }
</script>