@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Grado de Instrucción
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Grado de Instrucción</h6>
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
							<a href="#"
								class="btn btn-sm btn-primary btn-custom float-right"
								title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<table class="table table-big table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr class="text-center">
								<th>Nombre</th>
								<th>Descripción</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($instruction_degrees as $instruction_degree)
								<tr class="text-center">
									<td> {{ $instruction_degrees->name }} </td>
									<td> {{ $instruction_degrees->description }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="#" class="btn btn-warning btn-xs btn-icon btn-round" data-toggle="tooltip" title="Actualizar"><i class="fa fa-edit"></i></a>
											<!--<button class="btn btn-danger btn-xs btn-icon btn-round" onclick="delete_record('{{ route('position-types.destroy', $position_type) }}')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>-->
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
