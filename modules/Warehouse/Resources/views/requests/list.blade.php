@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
	Almacén
@stop

@section('maproute-title')
	Gestión de Almacenes
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Almacén</h6>
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
							<a href="{{ route('warehouse.request.create') }}" class='btn btn-sm btn-primary btn-custom float-right'>
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
								@foreach($warehouse_requests as $request)
									<tr>
										
										<td>{{ $types[$request->type] }}</td>
										<td>{{ $request->motive }}</td>
										<td>{{ $request->created_at }}</td>
										<td>{{ $request->state }}</td>
										<td width="10%" class="text-center">
											<div class="d-inline-flex">
												
												<button onclick=""
												class="btn btn-info btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Ver información de la Solicitud">
													<i class="fa fa-info-circle"></i>
												</button>

												{!! Form::open(['route' => ['warehouse.request.edit', $request], 'method' => 'GET']) !!}
												<button class="btn btn-warning btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Editar Solicitud">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['warehouse.request.destroy', $request], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar Solicitud">
													<i class="fa fa-trash"></i>
												</button>
												{!! Form::close() !!}
												
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

@stop