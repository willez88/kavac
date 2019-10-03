<div class="row">
	<div class="col-12">
		<div class="card" id="card_config_institution">
			<div class="card-header">
				<h6 class="card-title">
					Configurar Institución
					@include('buttons.help', [
						'helpId' => 'Institution',
						'helpSteps' => [
							[
								'element' => '#helpInstitutionImgs',
								'intro' => 'Corresponde a las imágenes institucionales, logotipo y banner o cintillo'
							],
							[
								'element' => '#helpInstitutionBasicData',
								'intro' => 'Corresponde a los datos básicos que identifican a la institución. Tome en cuenta que aquellos campos con (*) son obligatorios'
							],
							[
								'element' => '#helpInstitutionComplementaryData',
								'intro' => 'Corresponde a los datos con información complementaria de la institución, Esta información es opcional'
							],
							[
								'element' => '#helpInstitutionList',
								'intro' => 'Muestra un listado de instituciones registradas. Este elemento solo será mostrado siempre y cuando la aplicación se encuentre configurada para la gestión de múltiples instituciones'
							],
							[
								'element' => '#helpInstitutionButtons',
								'intro' => 'Botones para ejecutar las acciones de limpiar, cancelar o guardar los datos de la institución',
								'position' => 'left'
							]
						]
					])
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row" id="helpInstitutionImgs">
					<div class="col-md-4">
						<div class="form-group">
							<label for="">Logotipo Institucional</label>
							{!! Form::open([
                                'id' => 'formImgLogo', 'method' => 'POST', 'route' => 'upload-image.store',
                                'role' => 'form', 'class' => 'form', 'enctype' => 'multipart/form-data'
                            ]) !!}
                                @php
                                	$img_logo = (
                                		isset($model_institution) && !is_null($model_institution->logo)
                                	) ? $model_institution->logo->url : null;
                                @endphp
                                <img src="{{ asset($img_logo ?? 'images/no-image2.png') }}"
                                     alt="Logotipo institucional"
                                     class="img-fluid institution-logo" style="cursor:pointer"
                                     title="Click para cargar o modificar la imagen" data-toggle="tooltip"
                                     onclick="$('input[name=logo_image]').click()">
                                <input type="file" id="logo_image" name="logo_image" style="display:none"
                                       onchange="uploadSingleImage('formImgLogo', 'logo_image', 'logo_id', 'institution-logo')">
                                <div class="row row-delete-img">
                                	<div class="col-12">
                                		<div class="institution-logo text-center">
                                			<a class="img-delete" href="javascript:void(0)"
                                			   onclick="deleteImage($(this), $('#logo_id').val(), '2')">Eliminar</a>
                                		</div>
                                	</div>
                                </div>
                            {!! Form::close() !!}
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<label for="">Banner Institucional</label>
							{!! Form::open([
                                'id' => 'formImgBanner', 'method' => 'POST', 'route' => 'upload-image.store',
                                'role' => 'form', 'class' => 'form', 'enctype' => 'multipart/form-data'
                            ]) !!}
                                @php
                                	$img_banner = (
                                		isset($model_institution) && !is_null($model_institution->banner)
                                	) ? $model_institution->banner->url : null;
                                @endphp
                                <img src="{{ asset($img_banner ?? 'images/no-image3.png') }}"
                                     alt="Banner institucional"
                                     class="img-fluid institution-banner" style="cursor:pointer"
                                     title="Click para cargar o modificar la imagen" data-toggle="tooltip"
                                     onclick="$('input[name=banner_image]').click()">
                                <input type="file" id="banner_image" name="banner_image" style="display:none"
                                       onchange="uploadSingleImage('formImgBanner', 'banner_image', 'banner_id', 'institution-banner')">
                                <div class="row row-delete-img">
                                	<div class="col-12">
                                		<div class="text-center">
                                			<a class="img-delete" href="javascript:void(0)"
                                			   onclick="deleteImage($(this), $('#banner_id').val(), '3')">
                                				Eliminar
                                			</a>
                                		</div>
                                	</div>
                                </div>
                            {!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			{!! Form::model($model_institution, $header_institution) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					{{-- <div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div> --}}
					{!! Form::hidden('logo_id', null, ['readonly' => 'readonly', 'id' => 'logo_id']) !!}
					{!! Form::hidden('banner_id', null, ['readonly' => 'readonly', 'id' => 'banner_id']) !!}
					{!! Form::hidden('institution_id', (isset($model_institution))?$model_institution->id:'', [
						'readonly' => 'readonly', 'id' => 'institution_id'
					]) !!}

					<hr>
					<h6 class="md-title">Datos Básicos:</h6>
					<div id="helpInstitutionBasicData">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									{!! Form::label('onapre_code', 'Código ONAPRE', []) !!}
									{!! Form::text('onapre_code',
										(isset($model_institution))?$model_institution->onapre_code:old('onapre_code'), [
											'class' => 'form-control input-sm', 'id' => 'onapre_code',
											'data-toggle' => 'tooltip',
											'title' => 'Indique el código ONAPRE asignado a la institución (requerido)'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group{{ $errors->has('rif') ? ' has-error' : '' }} is-required">
									{!! Form::label('rif', 'R.I.F.', []) !!}
									{!! Form::text('rif',
										(isset($model_institution))?$model_institution->rif:old('rif'), [
											'class' => 'form-control input-sm', 'id' => 'rif',
											'data-toggle' => 'tooltip',
											'title' => 'Indique el número de registro de identificación fiscal (requerido)'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required{{ $errors->has('name') ? ' has-error' : '' }}">
									{!! Form::label('name', 'Nombre', []) !!}
									{!! Form::text('name',
										(isset($model_institution))?$model_institution->name:old('name'), [
											'class' => 'form-control input-sm', 'id' => 'name',
											'data-toggle' => 'tooltip',
											'title' => 'Introduzca el nombre de la institución (requerido)'
										]
									) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('acronym', 'Acrónimo (Nombre Corto)', []) !!}
									{!! Form::text('acronym',
										(isset($model_institution))?$model_institution->acronym:old('acronym'), [
											'class' => 'form-control input-sm', 'id' => 'acronym',
											'data-toggle' => 'tooltip',
											'title' => 'Introduzca el nombre corto de la institución'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('business_name', 'Razón Social', []) !!}
									{!! Form::text('business_name',
										(isset($model_institution))?$model_institution->business_name:old('business_name'), [
											'class' => 'form-control input-sm', 'id' => 'business_name',
											'data-toggle' => 'tooltip',
											'title' => 'Introduzca la razón social'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label(
										'country_id', 'Pais', []
									) !!}
									{!! Form::select('country_id', (isset($countries))?$countries:[], (isset($model_institution)) ? $model_institution->city->estate->country->id : null, [
										'class' => 'form-control select2', 'id' => 'country_id',
										'onchange' => 'updateSelect($(this), $("#estate_id"), "Estate")'
									]) !!}
									{{-- <i class="fa fa-plus-circle btn-add-record"></i> --}}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('estate_id', 'Estado', []) !!}
									{!! Form::select('estate_id', (isset($estates))?$estates:[], (isset($model_institution)) ? $model_institution->city->estate->id : null, [
										'class' => 'form-control select2', 'id' => 'estate_id',
										'onchange' => 'updateSelect($(this), $("#municipality_id"), "Municipality"), updateSelect($(this), $("#city_id"), "City")',
										'disabled' => (!isset($model_institution))
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('municipality_id', 'Municipio', []) !!}
									{!! Form::select(
										'municipality_id', (isset($municipalities))?$municipalities:[], null, [
											'class' => 'form-control select2', 'id' => 'municipality_id',
											'onchange' => 'updateSelect($(this), $("#parish_id"), "Parish")',
											'disabled' => (!isset($model_institution))
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('city_id', 'Ciudad', []) !!}
									{!! Form::select('city_id', (isset($cities))?$cities:[], null, [
										'class' => 'form-control select2', 'id' => 'city_id',
										'disabled' => (!isset($model_institution))
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							{{-- <div class="col-md-4">
								<div class="form-group">
									{!! Form::label('parish_id', 'Parroquia', []) !!}
									{!! Form::select('parish_id', (isset($parishes))?$parishes:[], null, [
										'class' => 'form-control select2', 'id' => 'parish_id',
										'disabled' => (!isset($model_institution))
									]) !!}
								</div>
							</div> --}}
							<div class="col-md-4">
								<div class="form-group is-required">
									{!! Form::label('postal_code', 'Código Postal', []) !!}
									{!! Form::text('postal_code',
										(isset($model_institution))?$model_institution->postal_code:old('postal_code'), [
											'class' => 'form-control input-sm', 'id' => 'postal_code',
											'data-toggle' => 'tooltip',
											'title' => 'Indique el código postal (requerido)'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									{!! Form::label('start_operations_date', 'Fecha de inicio de operaciones', []) !!}
									{!! Form::date('start_operations_date',
										(isset($model_institution))?$model_institution->start_operations_date:old('start_operations_date'), [
											'class' => 'form-control input-sm', 'id' => 'start_operations_date',
											'data-toggle' => 'tooltip',
											'title' => 'Indique la fecha de inicio de operaciones (requerido)'
										]
									) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('organism_adscript_id', 'Adscrito a', []) !!}
									{!! Form::select(
										'organism_adscript_id',
										(isset($organism_adscripts))?$organism_adscripts:[], null, [
											'class' => 'form-control select2', 'id' => 'organism_adscript_id'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('institution_sector_id', 'Sector', []) !!}
									{!! Form::select('institution_sector_id', (isset($sectors))?$sectors:[], null, [
										'class' => 'form-control select2', 'id' => 'institution_sector_id'
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('institution_type_id', 'Tipo', []) !!}
									{!! Form::select('institution_type_id', (isset($types))?$types:[], null, [
										'class' => 'form-control select2', 'id' => 'institution_type_id'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group is-required">
									{!! Form::label('legal_address', 'Dirección Fiscal', []) !!}
									{!! Form::textarea('legal_address', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la dirección fiscal de la institución  (requerido)',
										'id' => 'legal_address'
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('web', 'Sitio Web', []) !!}
									{!! Form::text('web',
										(isset($model_institution))?$model_institution->web:old('web'), [
											'class' => 'form-control input-sm', 'id' => 'web',
											'data-toggle' => 'tooltip',
											'title' => 'Indique la URL del sitio web'
										]
									) !!}
								</div>
								<div class="form-group">
									{!! Form::label('social_networks', 'Redes Sociales', []) !!}
									{!! Form::select(
										'social_networks', (isset($social_networks))?$social_networks:[], null, [
											'class' => 'form-control select2', 'multiple' => 'multiple',
											'id' => 'social_networks'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									{!! Form::label('active', 'Activa', []) !!}
									<div class="col-12">
										{!! Form::checkbox('active', true, null, [
											'id' => 'active', 'class' => 'form-control bootstrap-switch',
											'data-on-label' => 'SI', 'data-off-label' => 'NO'
										]) !!}
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('default', 'Institución por defecto', []) !!}
									<div class="col-12">
										{!! Form::checkbox('default', true, (isset($model_institution) && $model_institution->default)?null:true, [
											'id' => 'default', 'class' => 'form-control bootstrap-switch',
											'data-on-label' => 'SI', 'data-off-label' => 'NO'
										]) !!}
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									{!! Form::label('retention_agent', 'Agente de Retención', []) !!}
									<div class="col-12">
										{!! Form::checkbox('retention_agent', true, null, [
											'id' => 'retention_agent', 'class' => 'form-control bootstrap-switch',
											'data-on-label' => 'SI', 'data-off-label' => 'NO'
										]) !!}
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<h6 class="md-title">Datos Complementarios:</h6>
					<div id="helpInstitutionComplementaryData">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('legal_base', 'Base Legal', []) !!}
									{!! Form::textarea('legal_base', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la base legal constitutiva de la institución',
										'id' => 'legal_base'
									]) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('legal_form', 'Forma Jurídica', []) !!}
									{!! Form::textarea('legal_form', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la forma jurídica de la institución',
										'id' => 'legal_form'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('main_activity', 'Actividad Principal', []) !!}
									{!! Form::textarea('main_activity', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la actividad principal a la cual se dedica la institución',
										'id' => 'main_activity'
									]) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('mission', 'Misión', []) !!}
									{!! Form::textarea('mission', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la misión de la institución', 'id' => 'mission'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('vision', 'Visión', []) !!}
									{!! Form::textarea('vision', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la visión de la institución', 'id' => 'vision'
									]) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('composition_assets', 'Composición de Patrimonio', []) !!}
									{!! Form::textarea('composition_assets', null, [
										'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
										'title' => 'Indique la composición patrimonial de la institución',
										'id' => 'composition_assets'
									]) !!}
								</div>
							</div>
						</div>
					</div>

					@if (!is_null($paramMultiInstitution))
						<hr>
						<h6 class="md-title card-title">Instituciones Registradas</h6>
						<div class="row">
							<div class="col-12 text-right">
								@include('buttons.new', ['route' => 'javascript:void(0)', 'btnClass' => 'btn-new-institution'])
							</div>
						</div>

						<table class="table table-hover table-striped dt-responsive nowrap datatable"
							   id="helpInstitutionList">
							<thead>
								<tr>
									<th class="col-md-1">Logo</th>
									<th class="col-md-1">R.I.F</th>
									<th class="col-md-1">Código ONAPRE</th>
									<th class="col-md-8">Nombre</th>
									<th class="col-md-1">Activa</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($institutions as $institution)
									<tr>
										<td class="text-center">
											@if (!is_null($institution->logo))
												<img src="{{ url($institution->logo->url) }}"
													 alt="logo" class="img-fluid"
													 style="max-height:50px;">
											@endif
										</td>
										<td>
											<a href="javascript:void(0)"
											   onclick="loadInstitution('{{ $institution->id }}')">
												{{ $institution->rif }}
											</a>
										</td>
										<td>{{ $institution->onapre_code }}</td>
										<td>
											@if ($institution->acronym)
												{{ $institution->acronym }} -
											@endif
											{{ $institution->name }}
										</td>
										<td class="text-center">
											<span class="text-bold text-{{ ($institution->active)?'success':'danger' }}">
												{{ ($institution->active)?'SI':'NO' }}
											</span>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@endif
				</div>
				<div class="card-footer text-right">
					<div class="row">
						<div class="col-md-3 offset-md-9" id="helpInstitutionButtons">
							@include('layouts.form-buttons')
						</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

@section('extra-js')
	@parent
	{!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
	<script>
		$(document).ready(function() {
			if (typeof CkEditor !== 'undefined') {
				$.each([
					'legal_base', 'legal_form', 'main_activity', 'mission', 'vision', 'composition_assets'
				], function(index, element_id) {
					CkEditor.create(document.querySelector(`#${element_id}`), {
			            toolbar: [
			                'heading', '|',
			                'bold', 'italic', 'blockQuote', 'link', 'numberedList', 'bulletedList', '|',
			                'insertTable'
			            ],
			            language: 'es',
			        }).then(editor => {
			            window.editor = editor;
			        }).catch(error => {
			            console.error( error.stack );
			        });
				});
			}
			@if (!is_null($paramMultiInstitution))
				$(".btn-new-institution").on('click', function() {
					var form = $("#card_config_institution form");
					var clearEl = {
						val: [
							'input[type=text]', 'input[type=date]',
							'.select2:not(select[name^=DataTable])', 'textarea',
							"#logo_id", "#banner_id"
						],
						attr: [

						]
					};
					$.each(clearEl.val, function(index, el) {
						form.find(el).val('');
					});
					form.find('.select2').trigger('change');
					form.find('input[type=checkbox]').attr('checked', false);
					form.find('input[type=radio]').attr('checked', false);
					form.find('.bootstrap-switch').removeClass('bootstrap-switch-on');
					form.find('.bootstrap-switch').addClass('bootstrap-switch-off');
					form.find(".institution-logo").attr('src', "/images/no-image2.png");
					form.find(".institution-banner").attr('src', "/images/no-image3.png");
					form.find("#onapre_code").focus();
				});
			@endif
		});

		/**
		 * Carga datos de la instiotución seleccionada
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
		 * @param  {integer} id Identificador de la Institución a cargar
		 */
		var loadInstitution = function(id) {
			axios.get(`get-institution/details/${id}`).then(response => {
				if (response.data.result) {
					var institution = response.data.institution;
					$(".institution-logo").attr('src', "/images/no-image2.png");
					$("#logo_id").val('');
					$(".institution-banner").attr('src', "/images/no-image3.png");
					$("#banner_id").val('');
					if (institution.logo) {
						$(".institution-logo").attr('src', `/${institution.logo.url}`);
						$(".institution-logo").closest('.form-group').find('.row-delete-img').show();
						$("#logo_id").val(institution.logo.id);
					}
					if (institution.banner) {
						$(".institution-banner").attr('src', `/${institution.banner.url}`);
						$(".institution-banner").closest('.form-group').find('.row-delete-img').show();
						$("#banner_id").val(institution.banner.id);
					}
					$("#institution_id").val(institution.id);
					$("#onapre_code").val(institution.onapre_code);
					$("#rif").val(institution.rif);
					$("input[name=name]").val(institution.name);
					$("#acronym").val(institution.acronym);
					$("#business_name").val(institution.business_name);
					$("#country_id").val(institution.municipality.estate.country.id);
					$("#country_id").trigger('change');
					$("#estate_id").val(institution.municipality.estate.id);
					$("#estate_id").trigger('change');
					$("#municipality_id").val(institution.municipality.id);
					$("#municipality_id").trigger('change');
					$("#city_id").val(institution.city_id);
					$("#city_id").trigger('change');
					$("#postal_code").val(institution.postal_code);
					$("#start_operations_date").val(institution.start_operations_date);
					$("#institution_sector_id").val(institution.institution_sector_id);
					$("#institution_sector_id").trigger('change');
					$("#institution_type_id").val(institution.institution_type_id);
					$("#institution_type_id").trigger('change');
					$("#legal_address").val(institution.legal_address);
					$("#web").val(institution.web);
					$("#social_networks").val(institution.social_networks);
					$("#social_networks").trigger('change');
					$('#active').attr('checked', institution.active);
					var activeSwitchRemoveClass = (institution.active) ? 'off' : 'on';
					var activeSwitchAddClass = (institution.active) ? 'on' : 'off';
					$('#active.bootstrap-switch').removeClass(`bootstrap-switch-${activeSwitchRemoveClass}`);
					$('#active.bootstrap-switch').addClass(`bootstrap-switch-${activeSwitchAddClass}`);
					$('#default').attr('checked', institution.default);
					var defaultSwitchRemoveClass = (institution.default) ? 'off' : 'on';
					var defaultSwitchAddClass = (institution.default) ? 'on' : 'off';
					$('#default.bootstrap-switch').removeClass(`bootstrap-switch-${defaultSwitchRemoveClass}`);
					$('#default.bootstrap-switch').addClass(`bootstrap-switch-${defaultSwitchAddClass}`);
					$('#retention_agent').attr('checked', institution.retention_agent);
					var retAgentSwitchRemoveClass = (institution.retention_agent) ? 'off' : 'on';
					var retAgentSwitchAddClass = (institution.retention_agent) ? 'on' : 'off';
					$('#retention_agent.bootstrap-switch').removeClass(`bootstrap-switch-${retAgentSwitchRemoveClass}`);
					$('#retention_agent.bootstrap-switch').addClass(`bootstrap-switch-${retAgentSwitchAddClass}`);
					$("#legal_base").val(institution.legal_base);
					$("#legal_form").val(institution.legal_form);
					$("#main_activity").val(institution.main_activity);
					$("#mission").val(institution.mission);
					$("#vision").val(institution.vision);
					$("#composition_assets").val(institution.composition_assets);

				    $("#onapre_code").focus();
				}
			}).catch(error => {
				logs('setting-institution', 129, error, 'loadInstitution');
			});
		}
	</script>
@endsection
