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
					<h6 class="card-title">Movimientos de Almacén</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('warehouse.movement.create')])
						@include('buttons.minimize')
					</div>
				</div>

				
				<div class="card-body">
					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">			
									<th>Código</th>
									<th>Descripción</th>
									<th>Origen</th>
									<th>Destino</th>
									<th>Estado</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($movements as $movement)
									@if(!is_null($movement->start))
										<tr>
											<td>{{ $movement->id }}</td>
											<td>{{ $movement->description }}</td>
											<td>{{ isset($movement->start->warehouse)?$movement->start->warehouse->name:'' }}</td>
											<td>{{ $movement->finish->warehouse->name }}</td>
											<td>{{ ($movement->complete)?'Completado':'Pendiente' }}</td>

											<td width="10%" class="text-center">
												<div class="d-inline-flex">
													
													<warehouse-movement-info 
														route_list="warehouse/movements/vue-info/"
														:movement="{{$movement}}">
													</warehouse-movement-info>

													@role(['admin','warehouse'])
														@if(!($movement->complete == true))

														<warehouse-movement-pending
															:movementid="{{$movement->id}}">
														</warehouse-movement-pending>
														@endif
													@endrole

													{!! Form::open(['route' => ['warehouse.movement.edit', $movement], 'method' => 'GET']) !!}
													<button class="btn btn-warning btn-xs btn-icon btn-action"  
													data-toggle="tooltip" title="Editar Solicitud">
														<i class="icofont icofont-edit"></i>
													</button>
													{!! Form::close() !!}

													{!! Form::open(['route' => ['warehouse.movement.destroy', $movement], 'method' => 'DELETE']) !!}
													<button class="btn btn-danger btn-xs btn-icon btn-action"  data-toggle="tooltip" title="Eliminar Solicitud">
														<i class="fa fa-trash"></i>
													</button>
													{!! Form::close() !!}
													
												</div>
											</td>
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
						
					</div>
					
					
				</div>
			</div>
		</div>
	</div>	

@stop