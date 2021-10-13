@extends('budget::layouts.master')

@section('maproute-icon')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
    {{ __('Presupuesto') }}
@stop

@section('maproute-title')
    {{ __('Compromisos') }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">{{ __('Listado de Compromisos') }}</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include(
                            'buttons.new', [
                                'route' => route('budget.compromises.create')
                            ]
                        )
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <budget-compromise-list route_list='budget/compromises/vue-list'
                                            route_delete="budget/compromises"
                                            route_edit="budget/compromises/{id}/edit"/>
                </div>
            </div>
        </div>
    </div>
@stop
