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
    Cotizaciones
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleQuoteForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Nueva Cotización
                    @include('buttons.help', [
                        'helpId' => 'SaleQuoteForm',
                        'helpSteps' => get_json_resource('ui-guides/quotes/sale_quote_form.json', 'sale')
                    ])
                </h6>
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <sale-quote-form
                route_list='{{ url('sale/quotes')}}'
                :quoteid ="{!! (isset($quoteid)) ? $quoteid : 'null' !!}" :quote="{{ (isset($quote)) ? $quote : 'null' }}">
            </sale-quote-form>
        </div>
    </div>
</div>
@stop
