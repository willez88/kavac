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
					<h6 class="card-title">Solicitudes de Bienes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>

				
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<a href="{{ route('asset.request.create') }}" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Nuevo	</span>
							</a>	
						</div>
					</div>

					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">			
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
										
										<td>{{ $types[$request->type] }}</td>
										<td>{{ $request->motive }}</td>
										<td>{{ $request->created_at }}</td>
										<td>{{ $request->state }}</td>
										<td width="10%" class="text-center">
											<div class="d-inline-flex">
												
												<button onclick="openmodal( <?php echo($request->id) ?> );"
												class="btn btn-info btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Ver información de la Solicitud">
													<i class="fa fa-info-circle"></i>
												</button>
												
												@if ($request->type > 1)
													<request-prorroga
													:request='{{$request}}'>
													</request-prorroga>
												@endif


												<request-event 
													:id='{{$request->id}}'>
												</request-event>
												
												{!! Form::open(['route' => ['asset.request.deliver', $request], 'method' => 'PUT']) !!}
												<button class="btn btn-primary btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Entregar Equipos">
													<i class="icofont icofont-computer"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.request.edit', $request], 'method' => 'GET']) !!}
												<button class="btn btn-warning btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Editar Solicitud">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.request.destroy', $request], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar Solicitud">
													<i class="fa fa-trash"></i>
												</button>
												{!! Form::close() !!}

												<request-info 
													route_list="asset/requests/vue-info/"
													:request="{{$request}}">
												</request-info>
												
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
	</div>

	@role(['admin','asset'])
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Equipos Pendientes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<request-list-pending
							route_list='asset/requests/vue-pending-list'
							route_update='asset/requests'>
					</request-list-pending>										
				</div>				
			</div>			
		</div>	
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Prorrogas Pendientes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<request-list-pending
							route_list='asset/requests/prorrogas/vue-pending-list'
							route_update='asset/requests/prorroga'>
					</request-list-pending>										
				</div>				
			</div>			
		</div>	
	</div>
	@endrole



<div class="modal fade" tabindex="-1" role="form" id="add_request">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6>
					<i class="icofont icofont-read-book ico-2x"></i> 
					Información de la Solicitud Registrada
				</h6>
			</div>
					
			<div class="modal-body">
				<div class="row">        
					<div class="col-md-12">
						<b>Datos de la Solicitud</b>
					</div>

			        <div class="col-md-6">
						<div class="form-group">
							<label>Fecha de la Solicitud</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_date_init"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Motivo de la Solicitud</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_motive"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Tipo de Solicitud</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_type"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Fecha de Entrega de los Bienes</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_delivery_date"
								disabled="true">
						</div>
						
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Ubicación de los Bienes</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_ubication"
								disabled="true">
						</div>
					</div>

					<div class="col-md-12">
						<b>Información de Contacto del Agente Externo Responsable del Bien</b>    
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Nombre</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_external_agent_name"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Teléfono</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_external_agent_telf"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Correo</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="request_external_agent_email"
								disabled="true">
						</div>
					</div>

			    </div>
			</div>

	    	<div class="modal-footer">
	        	<button type="button" 
	            	    class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                	data-dismiss="modal"
	                	title="Cancelar y regresar">
	            	<i class="fa fa-ban"></i>
	        	</button>
			</div>
		</div>
	</div>
</div>


@stop

@section('extra-js')
<script type="text/javascript">

var records;
function openmodal($request) {
	axios.get("requests/info/" + $request).then(response => {
			
		records = response.data.record;
		$(".modal-body #request_date_init").val( records.date_init );
		$(".modal-body #request_motive").val( records.motive );
		$(".modal-body #request_type").val( records.type );
		$(".modal-body #asset_delivery_date").val( records.delivery_date );
		
		$(".modal-body #asset_ubication").val( records.ubication );
		$(".modal-body #request_external_agent_name").val( records.agent_name );
		$(".modal-body #request_external_agent_telf").val( records.agent_telf );
		$(".modal-body #request_external_agent_email").val( records.agent_email );
		$("#add_request").modal("show");

	})
			
}

</script>
@stop