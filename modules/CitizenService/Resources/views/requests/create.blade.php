@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-icon-mini')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-actual')
	Atención/Ciudadano
@stop

@section('maproute-title')
	Solicitud de Atención al Ciudadano
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<citizenservice-request-create
				route_list="citizenservice/requests"
				:requestid ="{!! (isset($request)) ? $request->id : 'null' !!}">
		</citizenservice-request-create>
	</div>
</div>
@stop
@section('modules-js')
    @parent
    {!! Html::script(mix('modules/payroll/js/app.js'), [], Request::secure()) !!}
@endsection
