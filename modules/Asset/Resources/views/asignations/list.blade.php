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
					<h6 class="card-title">Asignación de Bienes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.asignation.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">
									<th>Código</th>						
									<th>Trabajador Activo</th>
									<th>Fecha de Asignación</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($asset_asignations as $asignation)
									<tr>
										<td>{{ $asignation->id }}</td>
										<td>{{ $asignation->staff_id }}</td>
										<td class="text-center">{{ $asignation->created_at }}</td>
										<td width="10%" class="text-center">
											<div class="d-inline-flex">						

												<asignation-info 
													route_list="asset/asignations/vue-info/"
													:asignation="{{$asignation}}">
												</asignation-info>
												
												{!! Form::open(['route' => ['asset.asignation.edit', $asignation], 'method' => 'GET']) !!}
												<button class="btn btn-warning btn-xs btn-icon btn-action"  
												data-toggle="tooltip" title="Editar información de la Asignación">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.asignation.destroy', $asignation], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-action"  data-toggle="tooltip" title="Eliminar Asignación"><i class="fa fa-trash"></i></button>
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