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
	Gestión de Bienes
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>

				<div class="card-body">
					<label class="control-label">Tipo de Solicitud</label>
					<div class="row">
						<div class="col-6">
								{!! Form::select('request_id', (isset($requests))?$requests:[
										'Prestamo de Equipos (Uso Interno)',
										'Prestamo de Equipos (Uso Externo)',
										'Prestamo de Equipos para Agentes Externos',
										], [1,1], [		
										'class' => 'form-control select2',
										'placeholder' => 'Seleccione...',
										'title' => 'Indique el tipo de solicitud a realizar'
									]) !!}								
						</div>
						<div class="col-1">
							<a href="#" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Registrar	</span>
							</a>
						</div>

					</div>
							
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr>			
								<th>Tipo de Solicitud</th>
								<th>Motivo</th>
								<th>Fecha de la Solicitud</th>
								<th>Estado de la Solicitud</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($asset_requests as $request)
								<tr>
									
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td width="10%" class="text-center">
										<div class="d-inline-flex">
											
											<button class="btn btn-info btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Visualizar Solicitud">
												<i class="fa fa-filter"></i>
											</button>

											<button class="btn btn-warning btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Editar Solicitud">
												<i class="icofont icofont-edit"></i>
											</button>

												<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar Solicitud"><i class="fa fa-trash"></i></button>
	
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop


@section('extra-js')
<script>

var select = document.getElementById('request_id').options[1];
function myFunction() {
        console.log(select);
}


</script>
@stop