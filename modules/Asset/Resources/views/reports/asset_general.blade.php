@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes Institucionales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Reporte General de Bienes Institucionales</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{!! Form::open(['route' => ['asset.report.create',1], 'id' => 'form1','method' => 'GET', 'role' =>'form']) !!}
				<div class="card-body">

					<div class="row">
						<div class="form-group col-md-6">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('start_date', old('start_date'), [
			                    	'id' => 'start_date',
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Desde la fecha', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('end_date', old('end_date'), [
			                        'id' => 'end_date',
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Hasta la fecha', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<button type="Submit" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Buscar	</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-12" align="left">
							<button type="Submit" formaction ="../../asset/pdf" class='btn btn-sm btn-primary btn-custom'>
								<i class="fa fa-plus-circle"></i>
								<span>	Imprimir Resultados	</span>
							</button>
						</div>
					</div>
					{!! Form::close() !!}

					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">

									<th>Código</th>
									<th>Ubicación</th>
									<th>Condición Física</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>
								</tr>
							</thead>
							<tbody>
								@foreach($assets as $asset)
									<tr>
										<td> {{ $asset->serial_inventario }} </td>
								        <td> {{ $asset->institution_id }} </td>
								        <td> {{ $asset->condition->name }} </td>
								        <td> {{ $asset->status->name }} </td>
								        <td> {{ $asset->serial }} </td>
								        <td> {{ $asset->marca }} </td>
										<td> {{ $asset->model }} </td>
										
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop