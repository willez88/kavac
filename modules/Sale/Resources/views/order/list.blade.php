@extends('sale::layouts.master')

@section('maproute-icon')
    <i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
    Comercialización
@stop

@section('maproute-title')
    Solicitud de pedidos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitud de pedidos</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
			    <div class="card-body">
				  <div class="row">
                    {{-- Registrar pedidos de cliente --}}
				    <register-order-client></register-order-client>
				    <approve-order-client></approve-order-client>
                  </div>
                </div>
            </div>
        </div>
    </div>
@stop
