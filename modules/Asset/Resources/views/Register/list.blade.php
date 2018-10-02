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
					<h6 class="card-title">Bienes Institucionales</h6>
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
							<a href="{{ route('asset.create') }}" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Nuevo	</span>
							</a>	
						</div>
					</div>
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

									<th width="10%">Acciones</th>
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
										
										<td width="10%" class="text-center">
											<div class="d-inline-flex">
												
												<button class="btn btn-info btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Ver información del Bien">
													<i class="fa fa-info-circle"></i>
												</button>
												{!! Form::open(['route' => ['asset.asignation.asset_assign', $asset], 'method' => 'GET']) !!}
												<button class="btn btn-primary btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Asignar Bien">
													<i class="fa fa-filter"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.edit', $asset], 'method' => 'GET']) !!}

												<button class="btn btn-warning btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Editar Información del Bien">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.destroy', $asset], 'method' => 'DELETE']) !!}
													<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar Bien"><i class="fa fa-trash"></i></button>
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