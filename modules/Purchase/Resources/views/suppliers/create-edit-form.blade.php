@extends('purchase::layouts.master')

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
				{!! (!isset($model)) ? Form::open($header) : Form::model($model, $header) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
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
								<h6 class="card-title">Datos básicos del Proveedor</h6>
								<div class="row">
									<div class="col-4">
										<div class="form-group is-required{{ $errors->has('person_type') ? ' has-error' : '' }}">
											{!! Form::label('person_type', 'Tipo de Persona') !!}
											<div class="col-12">
												<label class="radio-inline">
													<span class="left">Natural</span>
													{!! Form::radio('person_type', 'N', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
												<label class="radio-inline">
													<span class="left">Jurídica</span>
													{!! Form::radio('person_type', 'J', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="form-group is-required{{ $errors->has('company_type') ? ' has-error' : '' }}">
											{!! Form::label('company_type', 'Tipo de Empresa') !!}
											<div class="col-12">
												<label class="radio-inline">
													<span class="left">Pública</span>
													{!! Form::radio('company_type', 'PU', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
												<label class="radio-inline">
													<span class="left">Privada</span>
													{!! Form::radio('company_type', 'PR', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
											{!! Form::label('active', 'Activo') !!}
											<div class="col-12">
												{!! Form::checkbox('active', true, null, [
													'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
													'data-off-label' => 'NO'
												]) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-3">
										<div class="form-group is-required{{ $errors->has('rif') ? ' has-error' : '' }}">
											{!! Form::label('rif', 'R.I.F.') !!}
											{!! Form::text('rif', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
									<div class="col-2">
										{!! Form::button('<i class="icofont icofont-check-alt"></i> Validar', [
											'class' => 'btn btn-sm btn-info btn-custom', 'style' => 'margin-top:25px',
											'onclick' => ''
										]) !!}
									</div>
									<div class="col-6 offset-1">
										<div class="form-group is-required{{ $errors->has('name') ? ' has-error' : '' }}">
											{!! Form::label('name', 'Nombre o Razón Social') !!}
											{!! Form::text('name', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-3">
										<div class="form-group is-required{{ $errors->has('purchase_supplier_type_id') ? ' has-error' : '' }}">
											{!! Form::label('purchase_supplier_type_id', 'Denominación Comercial') !!}
											{!! Form::select('purchase_supplier_type_id', $supplier_types, null, [
												'class' => 'form-control select2'
											]) !!}
										</div>
									</div>
									<div class="col-3">
										<div class="form-group is-required{{ $errors->has('purchase_supplier_object_id') ? ' has-error' : '' }}">
											{!! Form::label('purchase_supplier_object_id', 'Objeto Principal') !!}
											{!! Form::select('purchase_supplier_object_id', $supplier_objects, null, [
												'class' => 'form-control select2'
											]) !!}
										</div>
									</div>
									<div class="col-3">
										<div class="form-group is-required{{ $errors->has('purchase_supplier_branch_id') ? ' has-error' : '' }}">
											{!! Form::label('purchase_supplier_branch_id', 'Rama') !!}
											{!! Form::select('purchase_supplier_branch_id', $supplier_branches, null, [
												'class' => 'form-control select2'
											]) !!}
										</div>
									</div>
									<div class="col-3">
										<div class="form-group is-required{{ $errors->has('purchase_supplier_specialty_id') ? ' has-error' : '' }}">
											{!! Form::label('purchase_supplier_specialty_id', 'Especialidad') !!}
											{!! Form::select('purchase_supplier_specialty_id', $supplier_specialties, null, [
												'class' => 'form-control select2'
											]) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
											{!! Form::label('website', 'Sitio Web') !!}
											{!! Form::text('website', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
									<div class="col-6">
										<div class="form-group is-required{{ $errors->has('country_id') ? ' has-error' : '' }}">
											{!! Form::label('country_id', 'Pais') !!}
											{!! Form::select('country_id', $countries, null, [
												'class' => 'form-control select2', 'id' => 'country_id',
												'onchange' => 'updateSelect($(this), $("#estate_id"), "Estate")'
											]) !!}
										</div>
									</div>
									<div class="col-6">
										<div class="form-group is-required{{ $errors->has('estate_id') ? ' has-error' : '' }}">
											{!! Form::label('estate_id', 'Estado') !!}
											{!! Form::select('estate_id', $estates, null, [
												'class' => 'form-control select2', 'id' => 'estate_id',
												'onchange' => 'updateSelect($(this), $("#city_id"), "City")',
												'disabled' => (!isset($model))
											]) !!}
										</div>
									</div>
									<div class="col-6">
										<div class="form-group is-required{{ $errors->has('city_id') ? ' has-error' : '' }}">
											{!! Form::label('city_id', 'Ciudad') !!}
											{!! Form::select('city_id', $cities, null, [
												'class' => 'form-control select2', 'id' => 'city_id',
												'disabled' => (!isset($model))
											]) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="form-group is-required{{ $errors->has('direction') ? ' has-error' : '' }}">
											{!! Form::label('direction', 'Dirección Fiscal') !!}
											{!! Form::textarea('direction', null, [
												'class' => 'form-control ckeditor', 'rows' => '4'
											]) !!}
										</div>
									</div>
								</div>
								<hr>
								<h6 class="card-title">Datos de Contacto</h6>
								<div class="row">
									<div class="col-6">
										<div class="form-group is-required{{ $errors->has('contact_name') ? ' has-error' : '' }}">
											{!! Form::label('contact_name', 'Nombre') !!}
											{!! Form::text('contact_name', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
									<div class="col-6">
										<div class="form-group is-required{{ $errors->has('contact_email') ? ' has-error' : '' }}">
											{!! Form::label('contact_email', 'Correo electrónico') !!}
											{!! Form::text('contact_email', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
								</div>
								<hr>
								@php
									$phones = [];
									if (isset($model) && $model->phones) {
										foreach ($model->phones as $phone) {
											array_push($phones, [
												'type' => $phone->type,
												'area_code' => $phone->area_code,
												'number' => $phone->number,
												'extension' => $phone->extension ?? ''
											]);
										}
									}
								@endphp
								<phones initial_data="{{ ($phones) ? json_encode($phones) : '' }}"></phones>
							</div>
							<div class="tab-pane" id="rnc" role="tabpanel">
								<h6 class="card-title">Datos del Registro Nacional de Contratistas</h6>
								<div class="row">
									<div class="col-8">
										<div class="form-group is-required{{ $errors->has('rnc_status') ? ' has-error' : '' }}">
											{!! Form::label('rnc_status', 'Situación Actual') !!}
											<div class="col-12">
												<label class="radio-inline">
													<span class="left">Inscrito y no habilitado</span>
													{!! Form::radio('rnc_status', 'INH', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
												<label class="radio-inline">
													<span class="left">Inscrito y habilitado</span>
													{!! Form::radio('rnc_status', 'ISH', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
												<label class="radio-inline">
													<span class="left">Inscrito, habilitado y calificado</span>
													{!! Form::radio('rnc_status', 'IHC', null, [
														'class' => 'form-control bootstrap-switch', 'data-on-label' => 'SI',
														'data-off-label' => 'NO'
													]) !!}
												</label>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="form-group is-required{{ $errors->has('rnc_certificate_number') ? ' has-error' : '' }}">
											{!! Form::label('rnc_certificate_number', 'Número de Certificado') !!}
											{!! Form::text('rnc_certificate_number', null, [
												'class' => 'form-control input-sm'
											]) !!}
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="requirement_docs" role="tabpanel">
								<h6 class="card-title">Documentos a consignar</h6>
								<div class="row">
									<div class="col-6">
										{{-- Campo para registrar un arreglo de documentos --}}
										<input type="hidden" id="documents" name="documents" readonly>
										<ul class="feature-list list-group list-group-flush">
											@foreach ($requiredDocuments as $reqDoc)
									            <li class="list-group-item">
									                <div class="feature-list-indicator bg-info"></div>
									                <div class="feature-list-content p-0">
									                    <div class="feature-list-content-wrapper">
									                        <div class="feature-list-content-left">
									                            <div class="feature-list-heading">
									                                {{ $reqDoc->name }}
									                                <div class="badge badge-danger ml-2"
									                                	 title="El documento aún no ha sido cargado"
									                                	 data-toggle="tooltip">
									                                	por cargar
									                                </div>
									                            </div>
									                            <div class="feature-list-subheading">
									                            	<i>{{ $reqDoc->description ?? '' }}</i>
									                            </div>
									                        </div>
									                        <div class="feature-list-content-right feature-list-content-actions">
									                        	<button class="btn btn-simple btn-success btn-events"
									                        			title="Presione para cargar el documento"
									                        			data-toggle="tooltip" type="button"
									                        			onclick="$('#doc').click()">
									                        		<i class="fa fa-cloud-upload fa-2x"></i>
									                        	</button>
									                        	<button class="btn btn-simple btn-primary btn-events"
									                        			title="Presione para descargar el documento"
									                        			data-toggle="tooltip" type="button">
									                        		<i class="fa fa-cloud-download fa-2x"></i>
									                        	</button>
									                        	<input type="file" id="doc" name="doc" style="display:none"
									                        		   accept=".doc, .pdf, .odt, .docx">
									                        </div>
									                    </div>
									                </div>
									            </li>
											@endforeach
								        </ul>
									</div>
								</div>
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
@stop

@section('extra-js')
	@parent
	{!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
	<script>
		$(document).ready(function() {
			$(".nav-link").tooltip();
		});
	</script>
@stop
