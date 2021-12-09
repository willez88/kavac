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
    Orden de compra
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Contratación directa</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('purchase.direct_hire.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-order-direct-hire-list :records="{{ $records }}" route_edit="/purchase/direct_hire/{id}/edit" route_delete="/purchase/direct_hire" />
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Listado de ordenes de compra</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('purchase.purchase_order.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-order-list :records="{{ $records }}" route_edit="/purchase/purchase_order/{id}/edit" />
                </div>
            </div>
        </div>
    </div>
@stop
