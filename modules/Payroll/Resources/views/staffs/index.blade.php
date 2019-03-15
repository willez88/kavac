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
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Cédula de Identidad</th>
								<th>Correo Electrónico</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($staffs as $staff)
								<tr class="text-center">
									<td> {{ $staff->first_name }} </td>
									<td> {{ $staff->last_name }} </td>
									<td> {{ $staff->id_number }} </td>
									<td> {{ $staff->email }} </td>
									<td>
										<div class="d-inline-flex">
											<button onclick="openmodal( <?php echo($staff->id) ?> );"
												class="btn btn-info btn-xs btn-icon btn-round"
												data-toggle="tooltip" title="Información">
												<i class="fa fa-info-circle"></i>
											</button>
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

	<div class="modal fade" tabindex="-1" role="dialog" id="show_staff">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<h6>
						<i class="icofont icofont-read-book ico-2x"></i>
						Información del Personal
					</h6>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Código</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="code"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nombres</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="first_name"
									disabled="true">
				            </div>
				        </div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Apellidos</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="last_name"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Fecha de Nacimiento</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="birthdate"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Sexo</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="sex"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Correo Electrónico</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="email"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label for="active">Activo</label>
								<input id="active" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO" name="active" type="checkbox">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Página Web</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="website"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Dirección</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="direction"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Número de Hijos</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="sons"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Fecha de Ingreso en la Administración Pública</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="start_date_public_adm"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Fecha de Ingreso</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="start_date"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Fecha de Egreso</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="end_date"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nacionalidad</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="nationality"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Cédula de Identidad</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="id_number"
									disabled="true">
							</div>
						</div>


				        <div class="col-md-6">
							<div class="form-group">
								<label>Pasaporte</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="passport"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Estado Civil</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="marital_status_id"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Profesión</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="profession_id"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Ciudad</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="city_id"
									disabled="true">
							</div>
						</div>


				    </div>
				</div>

		    	<div class="modal-footer">
		        	<button type="button"
		            	    class="btn btn-warning btn-icon btn-round btn-modal-close"
		                	data-dismiss="modal"
		                	title="Cancelar y regresar">
		            	<i class="fa fa-ban"></i>
		        	</button>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	<script type="text/javascript">
		var records;
		function openmodal($staff) {
			axios.get("/payroll/staffs/" + $staff).then(response => {
				records = response.data.record;
				$(".modal-body #code").val( records.code );
				$(".modal-body #first_name").val( records.first_name );
				$(".modal-body #last_name").val( records.last_name );
				$(".modal-body #birthdate").val( records.birthdate );
				$(".modal-body #sex").val( records.sex );
				$(".modal-body #email").val( records.email );
				if(records.active)
				{
					$('#active').bootstrapSwitch('state', true);
				}
				else
				{
					$('#active').bootstrapSwitch('state', false);
				}
				$(".modal-body #website").val( records.website );
				$(".modal-body #direction").val( records.direction );
				$(".modal-body #sons").val( records.sons );
				$(".modal-body #start_date_public_adm").val( records.start_date_public_adm );
				$(".modal-body #start_date").val( records.start_date );
				$(".modal-body #end_date").val( records.end_date );
				$(".modal-body #nationality").val( records.nationality );
				$(".modal-body #id_number").val( records.id_number );
				$(".modal-body #passport").val( records.passport );
				$(".modal-body #marital_status_id").val( records.marital_status );
				$(".modal-body #profession_id").val( records.profession );
				$(".modal-body #city_id").val( records.city );
				$("#show_staff").modal("show");
			})
		}
	</script>
@stop
