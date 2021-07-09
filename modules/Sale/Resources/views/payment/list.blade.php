@extends('sale::layouts.master')

@section('maproute-icon')
	<i class="ion-social-usd-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-social-usd-outline"></i>
@stop

@section('maproute-actual')
	Comercialización
@stop

@section('maproute-title')
	Pagos
@stop

@section('content')
	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Pagos Registrados</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
			    <div class="card-body">
				  <div class="row">
                    {{-- link --}}
                  </div>
                </div>
            </div>
        </div>
    </div>

@stop
