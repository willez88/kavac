@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-actual')
	Compra
@stop

@section('maproute-title')
	Proveedores
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proveedor</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
			        <ul class="nav nav-tabs custom-tabs" role="tablist">
						<li class="nav-item">
							<a href="#default_data" class="nav-link active" data-toggle="tab" 
							   title="Datos básicos del proveedor">
								Datos Básicos
							</a>
						</li>
						<li class="nav-item">
							<a href="#rnc" class="nav-link" data-toggle="tab" 
							   title="Datos de Información del Registro Nacional de Contratistas (RNC)">
								Datos del RNC
							</a>
						</li>
						<li class="nav-item">
							<a href="#requirement_docs" class="nav-link" data-toggle="tab" 
							   title="Consignación de requisitos en físico y digital">
								Documentos
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="default_data" role="tabpanel">
							<div class="row">
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Tipo de Persona</label>
										<div class="col-12">
											<label class="radio-inline">
												<span class="left">Natural</span>
												<input type="radio" name="person_type" value="N" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO">
											</label>
											<label class="radio-inline">
												<span class="left">Jurídica</span>
												<input type="radio" name="person_type" value="J" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO"> 
											</label>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Tipo de Empresa</label>
										<div class="col-12">
											<label class="radio-inline">
												<span class="left">Pública</span>
												<input type="radio" name="person_type" value="PU" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO">
											</label>
											<label class="radio-inline">
												<span class="left">Privada</span>
												<input type="radio" name="person_type" value="PR" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO"> 
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group is-required">
										<label for="">R.I.F.</label>
										<input type="text" name="rif" class="form-control input-sm">
									</div>
								</div>
								<div class="col-6 offset-3">
									<div class="form-group is-required">
										<label for="">Nombre o Razón Social</label>
										<input type="text" name="name" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-3">
									<div class="form-group is-required">
										<label for="">Denominación Comercial</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group is-required">
										<label for="">Objeto Principal</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group is-required">
										<label for="">Rama</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
								<div class="col-3">
									<div class="form-group is-required">
										<label for="">Especialidad</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="">Sitio Web</label>
										<input type="text" class="form-control input-sm">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group is-required">
										<label for="">Pais</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group is-required">
										<label for="">Estado</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group is-required">
										<label for="">Ciudad</label>
										<select name="" id="" class="select2"></select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="form-group is-required">
										<label for="">Dirección Fiscal</label>
										<textarea name="" id="" rows="4" class="form-control input-sm"></textarea>
									</div>
								</div>
								<div class="col-6">

								</div>
							</div>
							<hr>
							<h5 class="md-title">Datos de Contacto</h5>
							<div class="row">
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Nombre</label>
										<input type="text" class="form-control input-sm">
									</div>
								</div>
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Correo electrónico</label>
										<input type="text" class="form-control input-sm">
									</div>
								</div>
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Teléfono(s)</label>
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="rnc" role="tabpanel">
							<div class="row">
								<div class="col-8">
									<div class="form-group is-required">
										<label for="">Situación Actual</label>
										<div class="col-12">
											<label class="radio-inline">
												<span class="left">Inscrito y no habilitado</span>
												<input type="radio" name="rnc_status" value="INH" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO">
											</label>
											<label class="radio-inline">
												<span class="left">Inscrito y habilitado</span>
												<input type="radio" name="rnc_status" value="ISH" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO"> 
											</label>
											<label class="radio-inline">
												<span class="left">Inscrito, habilitado y calificado</span>
												<input type="radio" name="rnc_status" value="IHC" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO"> 
											</label>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group is-required">
										<label for="">Número de Certificado</label>
										<input type="text" class="form-control input-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="requirement_docs" role="tabpanel">otro</div>
					</div>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	@parent
	<script>
		$(document).ready(function() {
			$(".nav-link").tooltip();
		});
	</script>
@stop