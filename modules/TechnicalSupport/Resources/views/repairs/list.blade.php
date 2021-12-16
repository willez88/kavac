@extends('technicalsupport::layouts.master')

@section('maproute-icon')
    <i class="icofont icofont-fix-tools"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-fix-tools"></i>
@stop

@section('maproute-actual')
    Soporte Técnico
@stop

@section('maproute-title')
    Gestión de Reparaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Reparaciones Asignadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <technicalsupport-repair-list
                        route_list="technicalsupport/repairs/vue-list">
                    </technicalsupport-repair-list>
                </div>
            </div>
        </div>
    </div>
@stop
