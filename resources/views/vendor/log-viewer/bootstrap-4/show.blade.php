<?php
/**
 * @var  Arcanedev\LogViewer\Entities\Log            $log
 * @var  Illuminate\Pagination\LengthAwarePaginator  $entries
 * @var  string|null                                 $query
 */
?>

@extends('layouts.app')

@section('maproute-icon')
    <i class="ion ion-ios-bookmarks"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion ion-ios-bookmarks"></i>
@stop

@section('maproute-actual')
    {{ __('Logs del Sistema') }}
@stop

@section('maproute-title')
    {{ __('Logs del Sistema') }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">{{ __('Log del [:date]', ['date' => $log->date]) }}</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Menú de Logs --}}
                        <div class="col-lg-2">
                            <div class="card mb-4">
                                <div class="card-header"><i class="fa fa-fw fa-flag"></i> {{ __('Niveles') }}</div>
                                <div class="list-group list-group-flush log-menu">
                                    @foreach($log->menu() as $levelKey => $item)
                                        @if ($item['count'] === 0)
                                            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center disabled">
                                                <span class="level-name">
                                                    {!! $item['icon'] !!} {{ $item['name'] }}
                                                </span>
                                                <span class="badge empty">
                                                    {{ $item['count'] }}
                                                </span>
                                            </a>
                                        @else
                                            <a href="{{ $item['url'] }}"
                                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center level-{{ $levelKey }}{{ $level === $levelKey ? ' active' : ''}}"
                                               data-toggle="tooltip" title="{!! ($levelKey == 'all') ? __('Todos los registros') : __('Registros marcados como :mark', ['mark' => $item['name']]) !!}">
                                                <span class="level-name">
                                                    {!! $item['icon'] !!} {{ $item['name'] }}
                                                </span>
                                                <span class="badge badge-level-{{ $levelKey }}">
                                                    {{ $item['count'] }}
                                                </span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Detalles del Log --}}
                        <div class="col-lg-10">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title">{{ __('Información del Log') }}:</h6>
                                    <div class="group-btns pull-right">
                                        <a href="{{ route('log-viewer::logs.download', [$log->date]) }}"
                                           class="btn btn-sm btn-success" title="{{ __('Descargar archivo de log') }}"
                                           data-toggle="tooltip">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="#delete-log-modal" class="btn btn-sm btn-danger btn-delete"
                                           data-toggle="modal" title="{{ __('Eliminar archivo de log') }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('Ruta del archivo') }}:</th>
                                                    <td colspan="7">{{ $log->getPath() }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('Registros de log') }}:</th>
                                                    <td>
                                                        <span class="badge badge-primary"
                                                              title="{{ __('Total de registros') }}: {{ $entries->total() }}" data-toggle="tooltip" data-placement="left">
                                                            {{ $entries->total() }}
                                                        </span>
                                                    </td>
                                                    <th>{{ __('Tamaño') }}:</th>
                                                    <td>
                                                        <span class="badge badge-primary"
                                                              title="{{ __('Tamaño del archivo') }}: {{ $log->size() }}"
                                                              data-toggle="tooltip" data-placement="left">
                                                            {{ $log->size() }}
                                                        </span>
                                                    </td>
                                                    <th>{{ __('Creado en') }}:</th>
                                                    <td>
                                                        <span class="badge badge-primary"
                                                              title="{{ __('Fecha de creación') }}: {{ $log->createdAt() }}"
                                                              data-toggle="tooltip" data-placement="left">
                                                            {{ $log->createdAt() }}
                                                        </span>
                                                    </td>
                                                    <th>{{ __('Actualizado en') }}:</th>
                                                    <td>
                                                        <span class="badge badge-primary"
                                                              title="{{ __('Última actualización') }}: {{ $log->updatedAt() }}" data-toggle="tooltip" data-placement="left">
                                                            {{ $log->updatedAt() }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{-- Formulario de búsqueda --}}
                                    <form action="{{ route('log-viewer::logs.search', [$log->date, $level]) }}"
                                          method="GET">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="query" name="query" class="form-control"
                                                       value="{!! $query !!}" placeholder="{{ __('Buscar') }}"
                                                       title="{{ __('Indique aquí lo que desea buscar en los registros del log') }}" data-toggle="tooltip">
                                                <div class="input-group-append">
                                                    @unless (is_null($query))
                                                        <a href="{{ route('log-viewer::logs.show', [$log->date]) }}"
                                                           class="btn btn-secondary" data-toggle="tooltip"
                                                           title="{{ __('Total de resultados encontrados') }}: {{ $entries->count() }}">
                                                            ({{ __(':count resultados', ['count' => $entries->count()]) }})&#160;
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </a>
                                                    @endunless
                                                    <button id="search-btn" class="btn btn-primary"
                                                            title="{{ __('Presione el botón para buscar los registros') }}"
                                                            data-toggle="tooltip">
                                                        <span class="fa fa-fw fa-search"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Registros del log detallados --}}
                            <div class="card mb-4">
                                @if ($entries->hasPages())
                                    <div class="card-header">
                                        <span class="badge badge-info float-right">
                                            {{ __('Página :current de :last', [
                                                'current' => $entries->currentPage(),
                                                'last' => $entries->lastPage()
                                            ]) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="entries" class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('ENV') }}</th>
                                                    <th style="width: 120px;">{{ __('Nivel') }}</th>
                                                    <th style="width: 65px;">{{ __('Hora') }}</th>
                                                    <th>Evento</th>
                                                    <th class="text-right">{{ __('Acciones') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($entries as $key => $entry)
                                                    <?php /** @var  Arcanedev\LogViewer\Entities\LogEntry  $entry */ ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <span class="badge badge-env cursor-pointer" title="{{ __('Entorno') }}: {!! $entry->env !!}" data-toggle="tooltip">
                                                                {{ $entry->env }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-level-{{ $entry->level }} cursor-pointer" title="{{ __('Nivel') }}: {!! $entry->level !!}" data-toggle="tooltip">
                                                                {!! $entry->level() !!}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge badge-info text-bold cursor-pointer"
                                                                  title="{{ __('Hora') }}: {!! $entry->datetime->format('H:i:s') !!}" data-toggle="tooltip">
                                                                {{ $entry->datetime->format('H:i:s') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $entry->header }}
                                                        </td>
                                                        <td class="text-right">
                                                            @if ($entry->hasStack())
                                                                <a class="btn btn-card-action btn-round btn-show-events collapsed"
                                                                   role="button" data-toggle="collapse"
                                                                   href="#log-stack-{{ $key }}"
                                                                   aria-expanded="false"
                                                                   aria-controls="log-stack-{{ $key }}"
                                                                   title="{{ __('Mostrar detalles') }}">
                                                                    {{-- <i class="fa fa-toggle-on"></i> Stack --}}
                                                                    <i class="now-ui-icons arrows-1_minimal-down"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if ($entry->hasStack())
                                                        <tr>
                                                            <td colspan="5" class="stack py-0">
                                                                <div class="stack-content collapse"
                                                                     id="log-stack-{{ $key }}">
                                                                     @php
                                                                        $stack = str_replace(
                                                                            "\n", "<br/>", $entry->stack()
                                                                        );
                                                                        $stack = str_replace(
                                                                            "[stacktrace]",
                                                                            "<b>[stacktrace]</b>",
                                                                            $stack
                                                                        );
                                                                        /**
                                                                         * reemplazar la numeración #1, #2, etc,
                                                                         * con una búsqueda de regex y colocarla
                                                                         * en negrita
                                                                         */
                                                                        /*$stack = str_replace(
                                                                            "/#[]/", replace, $stack
                                                                        );*/
                                                                     @endphp
                                                                    {!! $stack !!}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <span class="badge badge-secondary">
                                                                {{ trans('log-viewer::general.empty-logs') }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {!! $entries->appends(compact('query'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="{{ $log->date }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('ELIMINAR ARCHIVO DE LOG') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Estas seguro de querer') }} <span class="badge badge-danger">{{ __('ELIMINAR') }}</span> {{ __('este archivo de log') }} <span class="badge badge-primary">{{ $log->date }}</span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary mr-auto" data-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                            {{ __('ELIMINAR') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra-css')
    @parent
    <style>
        .btn-show-events {
            padding: .12rem .24rem;
        }
    </style>
@stop

@section('extra-js')
    <script>
        $(function () {
            $('.btn-show-events').tooltip();
            $('.btn-show-events').on('click', function() {
                if ($(this).hasClass('collapsed')) {
                    $(this).find('i').removeClass('arrows-1_minimal-down');
                    $(this).find('i').addClass('arrows-1_minimal-up');
                    $(this).attr('data-original-title', '{{ __('Ocultar detalles') }}').tooltip();
                }
                else {
                    $(this).find('i').addClass('arrows-1_minimal-down');
                    $(this).find('i').removeClass('arrows-1_minimal-up');
                    $(this).attr('data-original-title', '{{ __('Mostrar detalles') }}').tooltip();
                }
            });
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            deleteLogForm.on('submit', function(event) {
                event.preventDefault();
                submitBtn.button('loading');

                $.ajax({
                    url:      $(this).attr('action'),
                    type:     $(this).attr('method'),
                    dataType: 'json',
                    data:     $(this).serialize(),
                    success: function(data) {
                        submitBtn.button('reset');
                        if (data.result === 'success') {
                            deleteLogModal.modal('hide');
                            location.replace("{{ route('log-viewer::logs.list') }}");
                        }
                        else {
                            alert('{{ __('OOPS ! This is a lack of coffee exception !') }}')
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('{{ __('AJAX ERROR ! Check the console !') }}');
                        console.error(errorThrown);
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            @unless (empty(log_styler()->toHighlight()))
            $('.stack-content').each(function() {
                var $this = $(this);
                var html = $this.html().trim()
                    .replace(/({!! join('|', log_styler()->toHighlight()) !!})/gm, '<strong>$1</strong>');

                $this.html(html);
            });
            @endunless
        });
    </script>
@endsection
