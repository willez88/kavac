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
	Tipos de Concepto
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Tipo de Concepto</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('concept-types.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<table class="table table-big table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr class="text-center">
								<th>Nombre</th>
								<th>Descripción</th>
								<th>Signo</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($concept_types as $concept_type)
								<tr class="text-center">
									<td> {{ $concept_type->name }} </td>
									<td> {{ $concept_type->description }} </td>
									<td> {{ $concept_type->sign }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="{{ route('concept-types.edit', $concept_type) }}" class="btn btn-warning btn-xs btn-icon btn-action" data-toggle="tooltip" title="Actualizar"><i class="fa fa-edit"></i></a>
											<button class="btn btn-danger btn-xs btn-icon btn-action" onclick="delete_record('{{ route('concept-types.destroy', $concept_type) }}')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>
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
