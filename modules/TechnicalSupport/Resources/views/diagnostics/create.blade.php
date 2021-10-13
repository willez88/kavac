@extends('technicalsupport::layouts.master')

@section('maproute-icon')
    <i class="icofont icofont-fix-tools"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-fix-tools"></i>
@stop

@section('maproute-actual')
    Soporte Técnico
@stop

@section('maproute-title')
    Gestión de Diagnósticos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <technicalsupport-diagnostic-create
                :repair_id ="{!! (isset($technicalSupportRepair)) ? $technicalSupportRepair->id : 'null' !!}"
                route_list="technicalsupport/repairs">
            </technicalsupport-diagnostic-create>
        </div>
    </div>
@stop
@section('modules-js')
    @parent
    {!! Html::script(mix('modules/asset/js/app.js'), [], Request::secure()) !!}
@endsection
