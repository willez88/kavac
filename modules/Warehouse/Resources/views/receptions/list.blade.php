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
					<h6 class="card-title">Ingresos de Almacén</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('warehouse.reception.create')])
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
									<th>Almacén</th>
									<th>Fecha de Ingreso</th>
									<th>Estado</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($receptions as $reception)
									<tr>
										<td>{{ $reception->id }}</td>
										<td>{{ $reception->description }}</td>
										<td>{{ $reception->finish->warehouse->name }}</td>
										<td>{{ $reception->created_at }}</td>
										<td>{{ ($reception->complete)?'Completado':'Pendiente' }}</td>

										<td width="10%" class="text-center">
											<div class="d-inline-flex">
												
												<warehouse-reception-info 
													route_list="warehouse/receptions/vue-info/"
													:reception="{{$reception}}">
												</warehouse-reception-info>

												{!! Form::open(['route' => ['warehouse.reception.edit', $reception], 'method' => 'GET']) !!}
												<button class="btn btn-warning btn-xs btn-icon btn-action"  
												data-toggle="tooltip" title="Editar Solicitud">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['warehouse.reception.destroy', $reception], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-action"  data-toggle="tooltip" title="Eliminar Solicitud">
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