@extends('payroll::layouts.master')

@section('maproute-icon')
    <i class="ion-ios-folder-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-ios-folder-outline"></i>
@stop

@section('maproute-actual')
    Talento Humano
@stop

@section('maproute-title')
    Vacaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" id="cardPayrollVacationRequestForm">
                <div class="card-header">
                    <h6 class="card-title">Solicitud de vacaciones
                        @include('buttons.help', [
                            'helpId' => 'PayrollVacationRequestForm',
                            'helpSteps' => get_json_resource('ui-guides/requests/vacation_request_form.json', 'payroll')
                        ])
                    </h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <payroll-vacation-request-form
                    :id="{!! (isset($payrollVacationRequest)) ? $payrollVacationRequest->id : 'null' !!}"
                    route_list="{{ url('payroll/vacation-requests') }}">
                </payroll-vacation-request-form>
            </div>
        </div>
    </div>
@stop
