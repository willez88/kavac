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
                    <h6 class="card-title">Gestión de Requerimiento</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-requirements-form :supplier_objects="{{ $supplier_objects }}" 
                                                :date="{{ $date }}"
                                                :institutions="{{ $institutions }}"
                                                :purchase_supplier_types="{{ $purchase_supplier_types }}"
                                                :fiscal_years="{{ $fiscal_years }}"
                                                 />
                </div>
            </div>
        </div>
    </div>
@stop
