@extends('asset::layouts.master')

@section('maproute-icon')
    <i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-settings"></i>
@stop

@section('maproute-actual')
    Bienes
@stop

@section('maproute-title')
    Panel de Control
@stop

@section('content')

    {{-- Gráficos Estadísticos --}}
    <asset-dashboard-graphs></asset-dashboard-graphs>

    {{-- Histórico de Operaciones --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Histórico de Operaciones del Módulo de Bienes</h6>
                    <div class="card-btns">
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <asset-operations-history-list
                        route_list="{{ url('asset/dashboard/operations/vue-list') }}">
                    </asset-operations-history-list>
                </div>
            </div>
        </div>
    </div>
@stop
