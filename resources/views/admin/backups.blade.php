@extends('layouts.app')

@section('maproute-icon')
    <i class="fa fa-database"></i>
@stop

@section('maproute-icon-mini')
    <i class="fa fa-database"></i>
@stop

@section('maproute-actual')
    Respaldos
@stop

@section('maproute-title')
    Respaldos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Administración de Respaldos</h6>
                    <div class="card-btns">
                        <a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
                           data-toggle="tooltip">
                            <i class="now-ui-icons arrows-1_minimal-up"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <a id="create-new-backup-button" href="{{ url('backup/create') }}" 
                                class="btn btn-primary float-right" style="margin-bottom:2em;">
                                <i class="fa fa-plus"></i> Crear nuevo Respaldo
                            </a>
                        </div>
                    </div>
                    <table class="table table-hover table-striped dt-responsive nowrap datatable">
                        <thead>
                            <tr class="text-center">
                                <th>Archivo</th>
                                <th>Tamaño</th>
                                <th>Fecha</th>
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
                                        {{ $backup['last_modified'] }}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::button('<i class="fa fa-cloud-download"></i>', [
                                            'class' => 'btn btn-default btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => 'Descargar respaldo', 
                                            'onclick' => 'location.href="' . 
                                            url('backup/download/' .$backup['file_name'] ) .'"'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-cloud-upload"></i>', [
                                            'class' => 'btn btn-info btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => 'Restaurar respaldo', 
                                            'onclick' => '#'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o"></i>', [
                                            'class' => 'btn btn-danger btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => 'Eliminar respaldo', 
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
        function delete_backup(filename) {
            bootbox.confirm('Esta seguro de eliminar este respaldo?', function(result) {
                if (result) {
                    location.href="/backup/delete/" + filename;
                }
                event.preventDefault();
            });
        }
    </script>
@endsection