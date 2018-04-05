<div class="row" id="app">
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
			{!! Form::model($model_setting, $header_setting) !!}
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
									{!! Form::checkbox('support', true, 
										($model_setting!==null && $model_setting->support), [
										'id' => 'support', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Chat</label>
								<div class="col-12">
									{!! Form::checkbox('chat', true, 
										($model_setting!==null && $model_setting->chat), [
										'id' => 'chat', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Notificaciones</label>
								<div class="col-12">
									{!! Form::checkbox('notify', true, 
										($model_setting!==null && $model_setting->notify), [
										'id' => 'notify', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Banner en Reportes</label>
								<div class="col-12">
									{!! Form::checkbox('report_banner', true, 
										($model_setting!==null && $model_setting->report_banner), [
										'id' => 'report_banner', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Multi Gestión (varias instituciones)</label>
								<div class="col-12">
									{!! Form::checkbox('multi_institution', true, 
										($model_setting!==null && $model_setting->multi_institution), [
										'id' => 'multi_institution', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Firma Electrónica</label>
								<div class="col-12">
									{!! Form::checkbox('digital_sign', true, 
										($model_setting!==null && $model_setting->digital_sign), [
										'id' => 'digital_sign', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<h6>Datos Básicos</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de estados de los documentos" 
							   data-toggle="tooltip">
								<i class="icofont icofont-ui-copy ico-3x"></i>
								<span>Estatus<br>Documentos</span>
							</a>
						</div>
						<marital-status></marital-status>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de profesiones" data-toggle="tooltip">
								<i class="icofont icofont-graduate-alt ico-3x"></i>
								<span>Profesiones</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de tipos de instituciones" 
							   data-toggle="tooltip">
								<i class="icofont icofont-building-alt ico-3x"></i>
								<span>Tipo<br>Instituciones</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros para sectores de instituciones" 
							   data-toggle="tooltip">
								<i class="icofont icofont-focus ico-3x"></i>
								<span>Sector<br>Instituciones</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de unidades administrativas o departamentos" data-toggle="tooltip">
								<i class="icofont icofont-architecture-alt ico-3x"></i>
								<span>Unidades<br>Administrativas</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de clasificador de bienes" 
							   data-toggle="tooltip">
								<i class="icofont icofont-read-book ico-3x"></i>
								<span>Clasificador<br>Bienes</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Países" data-toggle="tooltip">
								<i class="icofont icofont-map ico-3x"></i>
								<span>Países</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Estado de un Pais" 
							   data-toggle="tooltip">
								<i class="icofont icofont-map-search ico-3x"></i>
								<span>Estados</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Municipios de un Estado" 
							   data-toggle="tooltip">
								<i class="icofont icofont-ui-map ico-3x"></i>
								<span>Municipios</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Parroquias de un Municipio" 
							   data-toggle="tooltip">
								<i class="icofont icofont-map-pins ico-3x"></i>
								<span>Parroquias</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Ciudades de un Estado" 
							   data-toggle="tooltip">
								<i class="icofont icofont-5-star-hotel ico-3x"></i>
								<span>Ciudades</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Impuestos" data-toggle="tooltip">
								<i class="icofont icofont-deal ico-3x"></i>
								<span>Impuestos</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de Deducciones o Retenciones" 
							   data-toggle="tooltip">
								<i class="icofont icofont-scroll-long-down ico-3x"></i>
								<span>Deducciones</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de entidades bancarias" 
							   data-toggle="tooltip">
								<i class="icofont icofont-bank-alt ico-3x"></i>
								<span>Bancos</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de agencias bancarias" 
							   data-toggle="tooltip">
								<i class="icofont icofont-business-man ico-3x"></i>
								<span>Agencias<br>Bancarias</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de tipos de cuenta bancaria" 
							   data-toggle="tooltip">
								<i class="icofont icofont-mathematical ico-3x"></i>
								<span>Tipos<br>Cuenta</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de cuentas bancarias" 
							   data-toggle="tooltip">
								<i class="icofont icofont-law-document ico-3x"></i>
								<span>Cuentas<br>Bancarias</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de chequeras" data-toggle="tooltip">
								<i class="icofont icofont-card ico-3x"></i>
								<span>Chequeras</span>
							</a>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>