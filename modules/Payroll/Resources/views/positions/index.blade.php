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
	Cargos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Cargos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<a href="{{ route('positions.create') }}" class='btn btn-success btn-round'>Registrar</a>
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripción</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($positions as $position)
								<tr>
									<td> {{ $position->name }} </td>
									<td> {{ $position->description }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="{{ route('positions.edit', $position->id) }}" class="btn btn-danger btn-xs btn-icon btn-round" data-toggle="tooltip" title="Actualizar"><i class="icofont icofont-edit"></i></a>
											<button class="btn btn-danger btn-xs btn-icon btn-round" data-toggle="modal" data-target="#exampleModal"><i class="icofont icofont-ui-delete"></i></button>
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

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Aviso</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>¿Seguro que desea eliminar los datos?</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger btn-xs">Eliminar</button>
					{!! Form::open(['route' => ['positions.destroy', $position->id], 'method' => 'DELETE']) !!}<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop