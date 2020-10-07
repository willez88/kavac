@extends('layouts.app')

@section('maproute-icon')
    <i class="fa fa-database"></i>
@stop

@section('maproute-icon-mini')
    <i class="fa fa-database"></i>
@stop

@section('maproute-actual')
    {{ __('Respaldos') }}
@stop

@section('maproute-title')
    {{ __('Respaldos') }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">{{ __('Administración de Respaldos') }}</h6>
                    <div class="card-btns">
                        <a href="#" class="card-minimize btn btn-card-action btn-round" title="{{ __('Minimizar') }}"
                           data-toggle="tooltip">
                            <i class="now-ui-icons arrows-1_minimal-up"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <a id="create-new-backup-button" href="{{ url('backup/create') }}"
                                class="btn btn-sm btn-primary btn-custom float-right" data-toggle="tooltip"
                                title="{{ __('Crear un nuevo respaldo') }}">
                                <i class="fa fa-plus-circle"></i>
                                <span>{{ __('Nuevo') }}</span>
                            </a>
                        </div>
                    </div>
                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
                        <thead>
                            <tr class="text-center">
                                <th>{{ __('Archivo') }}</th>
                                <th>{{ __('Tamaño') }}</th>
                                <th>{{ __('Fecha') }}</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                                <tr>
                                    <td>{{ $backup['file_name'] }}</td>
                                    {{-- <td>{{ humanFilesize($backup['file_size']) }}</td> --}}
                                    <td class="text-right">{{ $backup['file_size'] }}</td>
                                    <td class="text-center">
                                        {{--{{ formatTimeStamp($backup['last_modified'], 'F jS, Y, g:ia (T)') }}--}}
                                        {{ date('d-m-Y', $backup['last_modified']) }}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::button('<i class="fa fa-cloud-download"></i>', [
                                            'class' => 'btn btn-default btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => __('Descargar respaldo'),
                                            'onclick' => 'location.href="' .
                                            url('backup/download/' .$backup['file_name'] ) .'"'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-cloud-upload"></i>', [
                                            'class' => 'btn btn-info btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => __('Restaurar respaldo'),
                                            'onclick' => 'restore_backup("'.$backup['file_name'].'")'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o"></i>', [
                                            'class' => 'btn btn-danger btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => __('Eliminar respaldo'),
                                            'onclick' => 'delete_backup("'.$backup['file_name'].'")'
                                        ]) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    @parent
    <script>
        /**
         * Elimina el archivo de respaldo seleccionado
         *
         * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         *
         * @param     {string}         filename    Nombre del archivo a ser eliminado
         */
        function delete_backup(filename) {
            bootbox.confirm('{{ __('Esta seguro de eliminar este respaldo?') }}', function(result) {
                if (result) {
                    location.href="/backup/delete/" + filename;
                }
            });
        }

        /**
         * Ejecuta la acción corrspondiente para la restauración de registros
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         *
         * @param      {string}          filename    Nombre del archivo con el respaldo a restaurar
         */
        function restore_backup(filename) {
            bootbox.confirm({
                title: '{{ __('Restaurar datos') }}',
                message: `<p class='text-justify'>
                              {{ __('¿Está seguro de restaurar este respaldo? ') }}
                              {{ __('Se eliminará cualquier dato existente y se restaurará la información con este respaldo. ') }}
                              {{ __('Deberá autenticarse nuevamente luego de la restauración de la base de datos.') }}
                          </p>
                          <p class='text-justify'>
                              <b class='text-red'>¡ATENCIÓN!</b>
                              Este proceso puede ocasionar perdida parcial o total de los datos, proceda si esta
                              totalmente seguro.
                          </p>`,
                buttons: {
                    confirm: {
                        label: '<i class="fa fa-upload"></i> Restaurar',
                        className: 'btn btn-lg btn-primary'
                    },
                    cancel: {
                        label: '<i class="fa fa-ban"></i> Cancelar',
                        className: 'btn btn-lg'
                    }
                },
                callback: (result) => {
                    if (result) {
                        /** Muestra el mensaje de espera */
                        $('.preloader').show();
                        axios.post(
                            '/backup/restore', {filename: filename}
                        ).then(response => {
                            if (response.data.result) {
                                showMessageRestore(true);
                                return true;
                            }
                            /** Oculta el mensaje de espera */
                            $('.preloader').fadeOut(2000);
                            let msg = 'No fue posible realizar la restauración del respaldo, revise los logs del sistema';
                            showMessageRestore(false, msg);
                        }).catch(error => {
                            /** Oculta el mensaje de espera */
                            $('.preloader').fadeOut(2000);
                            let errorObj = error.response;
                            if (errorObj.status === 500 && errorObj.data.message.includes("Undefined table")) {
                                showMessageRestore(false, errorObj.data.message);
                            }
                        });
                    }
                }
            });
        }

        /**
         * [showMessageRestore description]
         *
         * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         *
         * @param     {boolean}             success    Determiuna si la restauración fue exitosa
         * @param     {String}              message    Mensaje a ser mostrado
         */
        function showMessageRestore(success, message = '') {
            $.gritter.add({
                title: (success) ? '{{ __('Éxito') }}' : '{{ __('Alerta!') }}',
                text: (success) ? "{{ __('Se ha restaurado la base de datos satisfactoriamente') }}" : message,
                class_name: (success) ? 'growl-success' : 'growl-danger',
                image: (success) ? "{{ asset('images/screen-ok.png') }}" : "{{ asset('images/screen-error.png') }}",
                sticky: false,
                time: 2500
            });
        }
    </script>
@endsection
