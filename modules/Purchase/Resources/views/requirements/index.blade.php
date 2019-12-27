@extends('purchase::layouts.master')

@section('maproute-icon')
    <i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-actual')
    Compra
@stop

@section('maproute-title')
    Requerimientos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Listado de Requerimientos</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('purchase.requirements.create')])
                        <a href="{{ route('purchase.requirements.base_budget') }}"
                            class="btn btn-sm btn-primary btn-custom"
                            title="Presupuesto base"
                            data-toggle="tooltip">
                            PRESUPUESTO BASE <i class="fa fa-list"></i>
                        </a>
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-requirements :records="{{ $requirements }}" add_buttons_action="{{ 'true' }}" route_edit="/purchase/requirements/{id}/edit" />
                </div>
            </div>
        </div>
    </div>
@stop
