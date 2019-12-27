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
                    <h6 class="card-title">Presupuesto base</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('purchase.requirements.index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <purchase-requirements :records="{{ $requirements }}" add_buttons_action="{{ 'false' }}" />
                </div>
            </div>
        </div>
    </div>
@stop
