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
                    <h6 class="card-title">
                        {{ __('Registros de Logs') }}
                        @include('buttons.help', [
                            'helpId' => 'logViewerDashboard',
                            'helpSteps' => get_json_resource('ui-guides/log_viewer_dashboard.json')
                        ])
                    </h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" id="helpGraph">
                            <canvas id="stats-doughnut-chart" height="300" class="mb-3"></canvas>
                        </div>
                        <div class="col-md-8" id="helpCards">
                            <div class="row">
                                @foreach($percents as $level => $item)
                                    <div class="col-sm-6 col-md-4 mb-3">
                                        <div class="info-box info-box-mini">
                                            <span class="info-box-icon level-{{ $level }} elevation-1">
                                                {!! log_styler()->icon($level) !!}
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{ $item['name'] }}</span>
                                                <span class="info-box-number">
                                                    <small>
                                                        {{ __(':count registros', ['count' => $item['count']]) }} -
                                                        {!! $item['percent'] !!}%
                                                    </small>
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar level-{{ $level }}"
                                                         style="width: {!! $item['percent'] !!}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-title">{{ __('Lista de Logs') }}</h6>
                    <div class="row">
                        <div class="col-12" id="helpList">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            @foreach($headers as $key => $header)
                                                <th scope="col"
                                                    class="{{ $key == 'date' ? 'text-left' : 'text-center' }}">
                                                    @if ($key == 'date')
                                                        <span class="badge badge-info">{{ $header }}</span>
                                                    @else
                                                        <span class="badge badge-level-{{ $key }}">
                                                            {!! log_styler()->icon($key) . ' ' . $header !!}
                                                        </span>
                                                    @endif
                                                </th>
                                            @endforeach
                                            <th scope="col" class="text-center">{{ __('Acciones') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($rows->count() > 0)
                                            @foreach($rows as $date => $row)
                                                <tr>
                                                    @php
                                                        $titleDate = '';
                                                    @endphp
                                                    @foreach($row as $key => $value)
                                                        <td class="{{ $key=='date'?'text-left':'text-center' }}">
                                                            @if ($key == 'date')
                                                                {{ $value }}
                                                                @php
                                                                    $titleDate = new Carbon\Carbon($date);
                                                                @endphp
                                                            @elseif ($value == 0)
                                                                <span class="text-level-{{ $key }}">
                                                                    {{ $value }}
                                                                </span>
                                                            @else
                                                                <a href="{{ route('log-viewer::logs.filter', [
                                                                    $date, $key
                                                                ]) }}" class="text-level-{{ $key }}"
                                                                title="{{ $value }} {{ __('incidencias registradas el') }} {{ $titleDate->format('d-m-Y') }}" data-toggle="tooltip" data-placement="{{ ($rows->count() < 2) ? 'bottom' : 'top' }}">
                                                                    {{ $value }}
                                                                </a>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td class="text-right">
                                                        <a href="{{ route('log-viewer::logs.show', [$date]) }}"
                                                           class="btn btn-xs btn-info btn-icon btn-action"
                                                           title="{{ __('Ver incidencias registradas en esta fecha') }}"
                                                           data-toggle="tooltip" data-placement="{{ ($rows->count() < 2) ? 'bottom' : 'top' }}">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                        <a href="{{ route('log-viewer::logs.download', [$date]) }}" class="btn btn-xs btn-success btn-icon btn-action" title="{{ __('Descargar archivo de log') }}" data-toggle="tooltip"
                                                        data-placement="{{ ($rows->count() < 2) ? 'bottom' : 'top' }}">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                        <a href="#delete-log-modal"
                                                           class="btn btn-xs btn-danger btn-icon btn-action"
                                                           data-log-date="{{ (!empty($titleDate)) ? $titleDate->format('d-m-Y'):$date }}" title="{{ __('Eliminar este registro') }}" data-toggle="tooltip" data-placement="{{ ($rows->count() < 2) ? 'bottom' : 'top' }}">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" class="text-center">
                                                    <span class="badge badge-secondary">
                                                        {{ trans('log-viewer::general.empty-logs') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            {!! $rows->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent
    {{-- DELETE MODAL --}}
    <div id="delete-log-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="delete-log-form" action="{{ route('log-viewer::logs.delete') }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="date" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('ELIMINAR ARCHIVO DE LOG') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-primary" data-loading-text="Loading&hellip;">
                            {{ __('Eliminar Archivo') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('extra-js')
    @parent
    {!! Html::script('js/chart.js', [], Request::secure()) !!}
    <script>
        $(function() {
            new Chart(document.getElementById("stats-doughnut-chart"), {
                type: 'doughnut',
                data: {!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
        $(function () {
            var deleteLogModal = $('div#delete-log-modal'),
                deleteLogForm  = $('form#delete-log-form'),
                submitBtn      = deleteLogForm.find('button[type=submit]');

            $("a[href='#delete-log-modal']").on('click', function(event) {
                event.preventDefault();
                var date = $(this).data('log-date');
                deleteLogForm.find('input[name=date]').val(date);
                deleteLogModal.find('.modal-body p').html(
                    'Esta seguro de <span class="badge badge-danger">{{ __('ELIMINAR') }}</span> {{ __('el archivo de log del') }} <span class="badge badge-primary">' + date + '</span> ?'
                );

                deleteLogModal.modal('show');
            });

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
                            location.reload();
                        }
                        else {
                            logs('log-viewer::dashboard', 228, data, 'deleteLogForm');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        logs('log-viewer::dashboard', 232, errorThrown, 'deleteLogForm');
                        submitBtn.button('reset');
                    }
                });

                return false;
            });

            deleteLogModal.on('hidden.bs.modal', function() {
                deleteLogForm.find('input[name=date]').val('');
                deleteLogModal.find('.modal-body p').html('');
            });
        });
    </script>
@endsection
