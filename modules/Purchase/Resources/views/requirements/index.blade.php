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
                        @if($codeAvailable)
                            @include('buttons.new', ['route' => route('purchase.requirements.create')])
                        @endif
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    @if(!$codeAvailable)
                        <div class="alert alert-danger" role="alert">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                                <ul>
                                    <li>Configurar el formato de código para el requerimiento en configuración de compras</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <purchase-requirements :record_list="{{ $requirements }}" 
                                            route_edit="/purchase/requirements/{id}/edit" />
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Presupuesto base</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        {{-- @include('buttons.new', ['route' => route('purchase.base_budget.create')]) --}}
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-base-budget route_edit="/purchase/base_budget/{id}/edit" />
                </div>
            </div>
        </div>
    </div>
@stop
