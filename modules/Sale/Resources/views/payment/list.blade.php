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
                    {!! Form::button('<i class="fa fa-download"></i>', [
                        'class'       => 'btn btn-sm btn-primary btn-custom',
                        'data-toggle' => 'tooltip',
                        'type'        => 'button',
                        'title'       => __('Descargar'),
                        'onclick'     => 'exportData()'
                    ]) !!}                    
                    @include('buttons.new', ['route' => route('payment.register.create')])
                    @include('buttons.minimize')
                </div>
            </div>
		    <div class="card-body">
                <payment-registered-list></payment-registered-list>
                {{-- <payment-registered-list route_edit="{{ url('sale/payment/{id}/edit') }}" /> --}}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Pagos pendientes</h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    {!! Form::button('<i class="fa fa-download"></i>', [
                        'class'       => 'btn btn-sm btn-primary btn-custom',
                        'data-toggle' => 'tooltip',
                        'type'        => 'button',
                        'title'       => __('Descargar'),
                        'onclick'     => 'exportData()'
                    ]) !!}     
                    @include('buttons.new', ['route' => route('warehouse.movement.create')])
                    @include('buttons.minimize')
                </div>
            </div>
            <div class="card-body">
                <pending-payments-list></pending-payments-list>
                {{-- <payment-registered-list route_edit="{{ url('sale/payment/{id}/edit') }}" /> --}}
            </div>
        </div>
    </div>
</div>                

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Pagos Aprobados</h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    {!! Form::button('<i class="fa fa-download"></i>', [
                        'class'       => 'btn btn-sm btn-primary btn-custom',
                        'data-toggle' => 'tooltip',
                        'type'        => 'button',
                        'title'       => __('Descargar'),
                        'onclick'     => 'exportData()'
                    ]) !!}     
                    @include('buttons.new', ['route' => route('warehouse.movement.create')])                    
                    @include('buttons.minimize')
                </div>
            </div>  
            <div class="card-body">
                <approved-payments-list></approved-payments-list>
                {{-- <payment-registered-list route_edit="{{ url('sale/payment/{id}/edit') }}" /> --}}
            </div>
        </div>
    </div>
</div>     

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Pagos de Anticipos Aprobados</h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    {!! Form::button('<i class="fa fa-download"></i>', [
                        'class'       => 'btn btn-sm btn-primary btn-custom',
                        'data-toggle' => 'tooltip',
                        'type'        => 'button',
                        'title'       => __('Descargar'),
                        'onclick'     => 'exportData()'
                    ]) !!}     
                    @include('buttons.new', ['route' => route('warehouse.movement.create')])                    
                    @include('buttons.minimize')
                </div>
            </div>  
            <div class="card-body">
                <approved-advance-payments-list></approved-advance-payments-list>
                {{-- <payment-registered-list route_edit="{{ url('sale/payment/{id}/edit') }}" /> --}}
            </div>
        </div>
    </div>
</div>     
@stop

@section('extra-js')
    @parent
    <script>
        function exportData() {
            location.href = '/sale/.......';
        };
    </script>
@endsection
                        