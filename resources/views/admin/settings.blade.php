@extends('layouts.app')

@section('maproute-icon')
	<i class="now-ui-icons ui-2_settings-90"></i>
@stop

@section('maproute-icon-mini')
	<i class="now-ui-icons ui-2_settings-90"></i>
@stop

@section('maproute-actual')
	Configuración
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configurar Institución</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<form action="" method="post" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="">Logotipo Institucional</label>
									<div class="col-12">
										<img src="{{ asset('images/no-image.png') }}" alt="Raised Image" class="rounded img-raised img-fluid" style="width:150px;">
									</div>
								</div>
							</div>
							<div class="col-md-9">
								<div class="form-group">
									<label for="">Banner Institucional</label>
									<div class="col-12">
										<img src="{{ asset('images/no-image.png') }}" alt="Raised Image" class="rounded img-raised img-fluid" style="width:100%;max-height: 150px">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Código ONAPRE</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">R.I.F.</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Nombre</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Razón Social</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">País</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Estado</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Municipio</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Parroquia</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Ciudad</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Código Postal</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Fecha de inicio de operaciones</label>
									<div class="col-12">
										<input type="date" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Adscrito a</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Sector</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Tipo</label>
									<div class="col-12">
										<select name="" id="" class="form-control select2">
											<option value="">Seleccione</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Sitio Web</label>
									<div class="col-12">
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label for="" class="control-label">Activa</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" 
										   class="form-control bootstrap-switch" 
										   data-on-label="SI" data-off-label="NO"/>
								</div>
							</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Base Legal</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Forma Jurídica</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Actividad Principal</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Misión</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Visión</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Dirección Fiscal</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Composición de Patrimonio</label>
									<div class="col-12">
										<textarea name="" id="" class="form-control" rows="4"></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
            						<label for="">Redes Sociales</label>
            						<select name="" id="" multiple="multiple" style="width:100%">
            							<option value="">Twitter</option>
            							<option value="">Instagram</option>
            							<option value="">Facebook</option>
            							<option value="">Google+</option>
            						</select>
            					</div>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Parámetros Generales</h6>
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
							<h6>Activar funciones de la aplicación</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Soporte Técnico</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" 
										   class="form-control bootstrap-switch" 
										   data-on-label="SI" data-off-label="NO"/>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Chat</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" class="form-control bootstrap-switch" 	    data-on-label="SI" data-off-label="NO" data-toggle="tooltip" 
										   title="Activar la comunicación por chat interno"/>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Notificaciones</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" class="form-control bootstrap-switch"	   data-on-label="SI" data-off-label="NO" data-toggle="tooltip" 
										   title="Activar las notificaciones del sistema"/>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Banner en Reportes</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" class="form-control bootstrap-switch"	   data-on-label="SI" data-off-label="NO" data-toggle="tooltip" 
										   title="Activar las notificaciones del sistema"/>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Multi Gestion (varias instituciones)</label>
								<div class="col-12">
									<input type="checkbox" name="checkbox" class="form-control bootstrap-switch"	   data-on-label="SI" data-off-label="NO" data-toggle="tooltip" 
										   title="Activar las notificaciones del sistema"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Módulos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Presupuesto</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Finanzas</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Compras</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Almacén</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Contabilidad</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Facturación</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Cuentas por Cobrar</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer"></div>
			</div>
		</div>
	</div>
@stop