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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('positions.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<table class="table table-big table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr class="text-center">
								<th>Nombre</th>
								<th>Descripción</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($positions as $position)
								<tr class="text-center">
									<td> {{ $position->name }} </td>
									<td> {{ $position->description }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="{{ route('positions.edit', $position) }}" class="btn btn-warning btn-xs btn-icon btn-action" data-toggle="tooltip" title="Actualizar"><i class="fa fa-edit"></i></a>
											<button class="btn btn-danger btn-xs btn-icon btn-action" onclick="delete_record('{{ route('positions.destroy', $position) }}')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>
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
