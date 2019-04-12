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
					<h6 class="card-title">Datos Personales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('payroll.staffs.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
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
												class="btn btn-info btn-xs btn-icon btn-action"
												data-toggle="tooltip" title="Información">
												<i class="fa fa-info-circle"></i>
											</button>
											<a href="{{ route('payroll.staffs.edit', $staff) }}" class="btn btn-warning btn-xs btn-icon btn-action" data-toggle="tooltip" title="Actualizar"><i class="fa fa-edit"></i></a>
											<button class="btn btn-danger btn-xs btn-icon btn-action" onclick="delete_record('{{ route('payroll.staffs.destroy', $staff) }}')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button>
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
						Información de los Datos Personales
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
								<label>Género</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="gender"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Nombres y apellidos de la persona de contacto</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="emergency_contact"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Teléfono de la persona de contacto</label>
								<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="emergency_phone"
									disabled="true">
							</div>
						</div>

				        <!--<div class="col-md-6">
							<div class="form-group">
								<label for="active">Activo</label>
								<input id="active" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO" name="active" type="checkbox">
							</div>
						</div>-->

						<div class="col-md-6">
							<div class="form-group">
								<label>Páis</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="country"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Estado</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="estate"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Municipio</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="municipality"
									disabled="true">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Parroquia</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="parish"
									disabled="true">
							</div>
						</div>

				        <div class="col-md-6">
							<div class="form-group">
								<label>Dirección</label>
				        		<input type="text"
									data-toggle="tooltip"
									class="form-control"
									id="address"
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
				$(".modal-body #nationality").val( records.nationality );
				$(".modal-body #id_number").val( records.id_number );
				$(".modal-body #passport").val( records.passport );
				$(".modal-body #email").val( records.email );
				$(".modal-body #birthdate").val( records.birthdate );
				$(".modal-body #gender").val( records.gender );
				$(".modal-body #emergency_contact").val( records.emergency_contact );
				$(".modal-body #emergency_phone").val( records.emergency_phone );
				/*if(records.active)
				{
					$('#active').bootstrapSwitch('state', true);
				}
				else
				{
					$('#active').bootstrapSwitch('state', false);
				}*/
				$(".modal-body #country").val( records.country );
				$(".modal-body #estate").val( records.estate );
				$(".modal-body #municipality").val( records.municipality );
				$(".modal-body #parish").val( records.parish );
				$(".modal-body #address").val( records.address );
				$("#show_staff").modal("show");
			})
		}
	</script>
@stop
