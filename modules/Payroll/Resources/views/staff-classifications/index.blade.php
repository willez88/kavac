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
	Clasificación del Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Clasificación del Personal</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<a href="{{ route('staff-classifications.create') }}" class='btn btn-success btn-round'>Registrar</a>
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripción</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($staff_classifications as $staff_classification)
								<tr>
									<td> {{ $staff_classification->name }} </td>
									<td> {{ $staff_classification->description }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="{{ route('staff-classifications.edit', $staff_classification) }}" class="btn btn-danger btn-xs btn-icon btn-round" data-toggle="tooltip" title="Actualizar"><i class="icofont icofont-edit"></i></a>
											{!! Form::open(['route' => ['staff-classifications.destroy', $staff_classification], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-round"><i class="icofont icofont-ui-delete"></i></button>
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
@stop