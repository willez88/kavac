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
                    @if(isset($requirement_edit))
                        <purchase-requirements-form :supplier_objects="{{ $supplier_objects }}" 
                                                    :institutions="{{ $institutions }}"
                                                    :purchase_supplier_objects="{{ $purchase_supplier_objects }}"
                                                    :measurement_units="{{ $measurement_units }}"
                                                    :requirement_edit="{{ $requirement_edit }}"
                                                    :department_list="{{ $department_list }}"
                                                     />
                    @else
                        <purchase-requirements-form :supplier_objects="{{ $supplier_objects }}" 
                                                    :institutions="{{ $institutions }}"
                                                    :purchase_supplier_objects="{{ $purchase_supplier_objects }}"
                                                    :measurement_units="{{ $measurement_units }}"
                                                     />
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
