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
    Contratación directa
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Gestión de ordenes de contratación directa</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    @if(!isset($record_edit))
                        <purchase-order-direct-hire-form :requirements="{{ $requirements }}"
                                             :currencies="{{ $currencies }}"
                                             :tax="{{ $tax }}"
                                             :tax_unit="{{ $tax_unit }}"
                                             :suppliers="{{ $suppliers }}"
                                             route_list="/purchase/purchase_order" />
                    @else
                        <purchase-order-direct-hire-form :requirements="{{ $requirements }}"
                                                 :currencies="{{ $currencies }}"
                                                 :tax="{{ $tax }}"
                                                 :tax_unit="{{ $tax_unit }}"
                                                 :suppliers="{{ $suppliers }}"
                                                 :record_edit="{{ $record_edit }}"
                                                 route_list="/purchase/purchase_order" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
