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
	Pedidos
@stop


@section('content')
<div class="row">
  <div class="col-12">
    <div class="card" id="cardSaleOrderForm">
	  <div class="card-header">
		<div class="card-btns">
		  @include('buttons.previous', ['route' => url()->previous()])
		  @include('buttons.minimize')
		</div>
	  </div>
	  <div class="card-body">
        <register-order-create
          route_list='{{ url('sale/order')}}'
          :orderid ="{!! (isset($orderid)) ? $orderid : 'null' !!}" :order="{{ (isset($order)) ? $order : 'null' }}">
        </register-order-create>
      </div>
	</div>
  </div>
</div>
@stop




