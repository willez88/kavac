@extends('budget::layouts.master')

@section('maproute-icon')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
    Presupuesto
@stop

@section('maproute-title')
    Compromisos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Listado de Compromisos</h6>
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
                    <budget-compromise-list route_list='{{ url('budget/compromises/vue-list') }}'
                                            route_delete="{{ url('budget/compromises') }}"
                                            route_edit="{{ url('budget/compromises/{id}/edit') }}"/>
                </div>
            </div>
        </div>
    </div>
@stop
