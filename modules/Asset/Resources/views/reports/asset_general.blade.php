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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => ['asset.report.create',1], 'id' => 'form1','method' => 'GET', 'role' =>'form']) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<b>Seleccione el Tipo de Busqueda</b>
						</div>
						<div class="form-group col-md-2">
							<label>Busqueda por Periodo </label>
							<div>
								{!! Form::radio('search_type', 0, true,
								[
									'id' => 'search_date',
									'class' => 'form-control bootstrap-switch',
									'data-on-label' => 'SI',
									'data-off-label' => 'NO',
									'onchange' => 'updateStatus()',
									'checked' => ($request->search_type==0)?true:false
								]) !!}
							</div>
						</div>
						<div class="form-group col-md-2">
							<label>Busqueda por Mes</label>
							<div>
								{!! Form::radio('search_type', 1, false,
								[
									'id' => 'search_mes',
									'class' => 'form-control bootstrap-switch',
									'data-on-label' => 'SI',
									'data-off-label' => 'NO',
									'checked' => ($request->search_type==1)?true:false
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<b>Fecha de Adquisición</b>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('mes_label', 'Mes:', []) !!}
								{!! Form::select('mes', (isset($mes))?$mes:
								[
									'Enero',
									'Febrero',
									'Marzo',
									'Abril',
									'Mayo',
									'Junio',
									'Julio',
									'Agosto',
									'Septiembre',
									'Octubre',
									'Noviembre',
									'Diciembre',

								], (isset($request->mes))?$request->mes:null, 
								[		
									'id' => 'mes_id',
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Todos',
									'title' => 'Indique el mes a buscar',
									'disabled' => ($request->search_type==0)?true:false
									
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('anual_label', 'Año:', []) !!}
								{!! Form::select('year', (isset($year))?$year:
								[], (isset($request->year))?$request->year:null, 
								[		
									'id' => 'year_id',
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Todos',
									'title' => 'Indique el Año a buscar',
									'disabled' => ($request->search_type==0)?true:false
									
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
							<label>Desde: </label>
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('start_date', old('start_date'), [
			                    	'id' => 'start_date',
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Fecha mínima de búsqueda', 
			                        'data-toggle' => 'tooltip',
			                        'disabled' => ($request->search_type==1)?true:false
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-4">
							<label>Hasta: </label>
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('end_date', old('end_date'), [
			                        'id' => 'end_date',
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Fecha maxima de búsqueda',
			                        'data-toggle' => 'tooltip',
			                        'disabled' => ($request->search_type==1)?true:false
			                    ]) !!}
			                </div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-12">
							<button type="Submit" class='btn btn-sm btn-info float-right'>
								<i class="fa fa-search"></i>
								<span>	Buscar	</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-12" align="left">

							<a type="button" href="../../asset/pdf2" target='_blank' class='btn btn-sm btn-primary btn-custom'>
								<i class="fa fa-plus-circle"></i>
								<span>	Generar Reporte	</span>
							</a>
							
						</div>
					</div>
					{!! Form::close() !!}

					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">

									<th>Código</th>
									<th>Condición Física</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Fecha de Registro</th>
								</tr>
							</thead>
							<tbody>
								@foreach($assets as $asset)
									<tr>
										<td> {{ $asset->inventory_serial }} </td>
								        <td> {{ $asset->assetCondition->name }} </td>
								        <td> {{ $asset->assetStatus->name }} </td>
								        <td> {{ $asset->serial }} </td>
								        <td> {{ $asset->marca }} </td>
										<td> {{ $asset->model }} </td>
										<td> {{ $asset->created_at->format('d-m-Y') }} </td>
										
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<asset-report-create
				route_list='{{ url('asset/registers/vue-list')}}'>
			</asset-report-create>
		</div>
	</div>

@stop

@section('extra-js')
<script type="text/javascript">
	var search_mes = document.getElementById('search_date');
	var search_periodo = document.getElementById('search_mes');

	var periodo_init = document.getElementById('start_date');
	var periodo_end = document.getElementById('end_date');

	var meses = document.getElementById('mes_id');
	var years = document.getElementById('year_id');

	function updateStatus(){
		if (search_mes.checked){
			meses.disabled =true;
			years.disabled =true;
			periodo_end.disabled=false;
			periodo_init.disabled=false;
		}else{
			meses.disabled =false;
			years.disabled =false;
			periodo_end.disabled=true;
			periodo_init.disabled=true;
		}
	}
</script>
@stop
