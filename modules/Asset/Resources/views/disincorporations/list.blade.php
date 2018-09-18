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
					<h6 class="card-title">Desincorporación de Bienes</h6>
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
							<a href="{{ route('asset.disincorporation.create') }}" class='btn btn-sm btn-primary btn-custom float-right'
								title="Desincorporar un bien Previamente Asignado"
								data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>	Nuevo	</span>
							</a>	
						</div>
					</div>
					
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr class="text-center">
								<th>Código</th>						
								<th>Descripción del Bien</th>
								<th>Ubicación</th>
								<th>Trabajador Activo</th>
								<th>Fecha de Asignación</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($asset_disincorporations as $disincorporation)
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td class="text-center"></td>
									<td width="10%" class="text-center">
										<div class="d-inline-flex">
											
											<button class="btn btn-info btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Visualizar ficha">
												<i class="fa fa-filter"></i>
											</button>

											<button class="btn btn-warning btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Reasignar bien">
												<i class="icofont icofont-edit"></i>
											</button>
											
											<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
										
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