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
Reportes de Disponibilidad Presupuestaria
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="budgetAvailability">
            <div class="card-header">
                <h6 class="card-title">
                    Disponibilidad Presupuestaria
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <div class="card-body">
                <budget-availability url="{{ route('budget.report.budgetAvailabilityPdf') }}" budget-items="{{ $budgetItems }}" />
            </div>
        </div>
    </div>
</div>
@stop