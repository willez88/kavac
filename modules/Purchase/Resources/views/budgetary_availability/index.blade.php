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
    Disponibilidad presupuestaria
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Disponibilidad presupuestaria</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-budgetary-availability :records="{{ $record_items }}"
                                                    :currency="{{ $currency }}"
                                                    :supplier="{{ $supplier }}"
                                                    :budget_items="{{ $budget_items }}"
                                                    :specific_actions="{{ $specific_actions }}"
                                                    :has_budget="{{ isset($has_budget)?'true':'false' }}"/>
                </div>
            </div>
        </div>
    </div>
@stop
