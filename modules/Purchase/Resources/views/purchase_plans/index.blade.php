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
    Plan de compra
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Listado de planes de compra</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('purchase.purchase_plans.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    {{-- <purchase-requirements :record_list="{{ $requirements }}" 
                                            route_edit="/purchase/requirements/{id}/edit" /> --}}
                </div>
            </div>
        </div>
    </div>
@stop
