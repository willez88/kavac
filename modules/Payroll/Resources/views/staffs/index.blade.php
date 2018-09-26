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
	Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Personal</h6>
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
							<a href="{{ route('staffs.create') }}"
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
								<th>Código</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Nacionalidad</th>
								<th>Cédula de Identidad</th>
								<th>Número de Pasaporte</th>
								<th>Correo Electrónico</th>
								<th>Fecha de Nacimiento</th>
								<th>Sexo</th>
								<th>Estado Civil</th>
								<th>Profesión</th>
								<th>Estatus en la Institución</th>
								<th>Sitio Web</th>
								<th>Número de Hijos</th>
								<th>Fecha de Inicio en la Administración Pública</th>
								<th>Fecha de Igreso en la Institución</th>
								<th>Fecha de Egreso de la Institución</th>
								<th>Ciudad</th>
								<th>Dirección</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($staffs as $staff)
								<tr class="text-center">
									<td> {{ $staff->code }} </td>
									<td> {{ $staff->first_name }} </td>
									<td> {{ $staff->last_name }} </td>
									<td> {{ $staff->nationality }} </td>
									<td> {{ $staff->id_number }} </td>
									<td> {{ $staff->passport }} </td>
									<td> {{ $staff->email }} </td>
									<td> {{ $staff->birthdate }} </td>
									<td> {{ $staff->sex }} </td>
									<td> {{ $staff->marital_status_id }} </td>
									<td> {{ $staff->profession_id }} </td>
									@if( $staff->active == 1 )
										<td> Si </td>
									@else
										<td> No </td>
									@endif
									<td> {{ $staff->website }} </td>
									<td> {{ $staff->sons }} </td>
									<td> {{ $staff->start_date_adm_public }} </td>
									<td> {{ $staff->start_date }} </td>
									<td> {{ $staff->end_date }} </td>
									<td> {{ $staff->city_id }} </td>
									<td> {{ $staff->direction }} </td>
									<td>
										<div class="d-inline-flex">
											<a href="{{ route('staffs.edit', $staff) }}" class="btn btn-warning btn-xs btn-icon btn-round" data-toggle="tooltip" title="Actualizar"><i class="fa fa-edit"></i></a>
											<button class="btn btn-danger btn-xs btn-icon btn-round" onclick="delete_record('{{ route('staffs.destroy', $staff) }}')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>
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