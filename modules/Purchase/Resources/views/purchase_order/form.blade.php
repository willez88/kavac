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
                    <h6 class="card-title">Gestión de ordenes de compra</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    @if(!isset($record_edit))
                        <purchase-order-form :requirements="{{ $requirements }}"
                                             :currencies="{{ $currencies }}"
                                             :tax="{{ $tax }}"
                                             :tax_unit="{{ $tax_unit }}"
                                             :suppliers="{{ $suppliers }}" />
                    @else
                        <purchase-order-form :requirements="{{ $requirements }}"
                                                 :currencies="{{ $currencies }}"
                                                 :tax="{{ $tax }}"
                                                 :tax_unit="{{ $tax_unit }}"
                                                 :suppliers="{{ $suppliers }}"
                                                 :record_edit="{{ $record_edit }}"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
