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
    Adelanto de prestaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" id="cardPayrollBenefitRequestForm">
                <div class="card-header">
                    <h6 class="card-title">Solicitud de adelanto de prestaciones
                        @include('buttons.help', [
                            'helpId' => 'PayrollBenefitsRequestFormForm',
                            'helpSteps' => get_json_resource('ui-guides/requests/benefit_request_form.json', 'payroll')
                        ])
                    </h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <payroll-benefits-request-form
                    :id="{!! (isset($payrollBenefitsRequest)) ? $payrollBenefitsRequest->id : 'null' !!}"
                    route_list="{{ url('payroll/benefits-requests') }}">
                </payroll-benefits-request-form>
            </div>
        </div>
    </div>
@stop
