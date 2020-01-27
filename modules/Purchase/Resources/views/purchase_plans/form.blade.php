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
                    <h6 class="card-title">Gestión de plan de compra</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    @if(!isset($record_edit))
                        <purchase-plan-form :purchase_process="{{ $purchase_process }}" 
                                            :purchase_types="{{ $purchase_types }}" />
                    @else
                        <purchase-plan-form :purchase_process="{{ $purchase_process }}" 
                                            :purchase_types="{{ $purchase_types }}"
                                            :record_edit="{{ $record_edit }}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
