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
    Propuesta técnica
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleTechnicalProposalForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Completar propuesta técnica
                    @include('buttons.help', [
                        'helpId' => 'SaleTechnicalProposalForm',
                    ])
                </h6>
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <sale-technical-proposal-create
                :serviceid ="{!! (isset($saleTechnicalProposal)) ? $saleTechnicalProposal->id : 'null' !!}">
            </sale-technical-proposal-create>
        </div>
    </div>
</div>
@stop
