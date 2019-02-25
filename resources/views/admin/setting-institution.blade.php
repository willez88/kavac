@section('extra-js')
	@parent
	<script>
		$(document).ready(function() {
			/*$("#logo_id").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 1500,
			    showClose: false,
			    showCaption: false,
			    showBrowse: false,
			    browseOnZoneClick: true,
			    removeLabel: '',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-logo_id',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="{{ asset('images/default-avatar.png') }}" alt="Your Avatar"><h6 class="text-muted">Click to select</h6>',
			    layoutTemplates: {main2: '{preview} {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});*/

			/*$("#banner_id").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 1500,
			    showClose: false,
			    showCaption: false,
			    showBrowse: false,
			    browseOnZoneClick: true,
			    removeLabel: '',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-banner_id',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="{{ asset('images/default-avatar.png') }}" alt="Your Avatar"><h6 class="text-muted">Click to select</h6>',
			    layoutTemplates: {main2: '{preview} {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});*/
		});
	</script>
@endsection

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
			{!! Form::model($model_institution, $header_institution) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Logotipo Institucional</label>
								<div class="kv-avatar">
					                <div class="file-loading">
					                    <input id="logo_id" name="logo_id" type="file" class="file-element">
					                </div>
					            </div>
								@if ($model_institution!==null && $model_institution->logo_id)
									<div class="col-12 text-center">
										<img src="{{ url($model_institution->logo->url) }}" class="img-fluid" style="max-height:150px;margin:0 auto;" alt="logo actual">
									</div>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Banner Institucional</label>
								<div class="kv-avatar">
					                <div class="file-loading">
					                    <input id="banner_id" name="banner_id" type="file" class="file-element input-sm">
					                </div>
					            </div>
								@if ($model_institution!==null && $model_institution->banner_id)
									<div class="col-12">
										<img src="{{ url($model_institution->banner->url) }}" class="img-fluid" style="max-height:150px;margin:0 auto;" alt="banner actual">
									</div>
								@endif
							</div>
						</div>
					</div>
					<hr>
					<h6 class="md-title">Datos Básicos:</h6>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group is-required">
								{!! Form::label('onapre_code', 'Código ONAPRE', []) !!}
								{!! Form::text('onapre_code', 
									(isset($model_institution))?$model_institution->onapre_code:old('onapre_code'), [
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control input-sm', 
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
								{!! Form::select('country_id', (isset($countries))?$countries:[], null, [
									'class' => 'form-control select2',
									'onchange' => 'updateSelect($(this).val(), $("#estate_id"), "Estate")'
								]) !!}
								{{-- <i class="fa fa-plus-circle btn-add-record"></i> --}}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('estate_id', 'Estado', []) !!}
								{!! Form::select('estate_id', (isset($estates))?$estates:[], null, [
									'class' => 'form-control select2', 'id' => 'estate_id'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('municipality_id', 'Municipio', []) !!}
								{!! Form::select(
									'municipality_id', (isset($municipalities))?$municipalities:[], null, [
										'class' => 'form-control select2'
									]
								) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('city_id', 'Ciudad', []) !!}
								{!! Form::select('city_id', (isset($cities))?$cities:[], null, [
									'class' => 'form-control select2'
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('parish_id', 'Parroquia', []) !!}
								{!! Form::select('parish_id', (isset($parishes))?$parishes:[], null, [
									'class' => 'form-control select2'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group is-required">
								{!! Form::label('postal_code', 'Código Postal', []) !!}
								{!! Form::text('postal_code', 
									(isset($model_institution))?$model_institution->postal_code:old('postal_code'), [
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control input-sm', 
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
										'class' => 'form-control select2'
									]
								) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('institution_sector_id', 'Sector', []) !!}
								{!! Form::select('institution_sector_id', (isset($sectors))?$sectors:[], null, [
									'class' => 'form-control select2'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('institution_type_id', 'Tipo', []) !!}
								{!! Form::select('institution_type_id', (isset($types))?$types:[], null, [
									'class' => 'form-control select2'
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
									'title' => 'Indique la dirección fiscal de la institución  (requerido)'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('web', 'Sitio Web', []) !!}
								{!! Form::text('web', 
									(isset($model_institution))?$model_institution->web:old('web'), [
										'class' => 'form-control input-sm', 
										'data-toggle' => 'tooltip',
										'title' => 'Indique la URL del sitio web'
									]
								) !!}
							</div>
							<div class="form-group">
								{!! Form::label('social_networks', 'Redes Sociales', []) !!}
								{!! Form::select(
									'social_networks', (isset($social_networks))?$social_networks:[], null, [
										'class' => 'form-control select2', 'multiple' => 'multiple'
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
					<hr>
					<h6 class="md-title">Datos Complementarios:</h6>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('legal_base', 'Base Legal', []) !!}
								{!! Form::textarea('legal_base', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip', 
									'title' => 'Indique la base legal constitutiva de la institución'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('legal_form', 'Forma Jurídica', []) !!}
								{!! Form::textarea('legal_form', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
									'title' => 'Indique la forma jurídica de la institución'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('main_activity', 'Actividad Principal', []) !!}
								{!! Form::textarea('main_activity', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
									'title' => 'Indique la actividad principal a la cual se dedica la institución'
								]) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('mission', 'Misión', []) !!}
								{!! Form::textarea('mission', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
									'title' => 'Indique la misión de la institución'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('vision', 'Visión', []) !!}
								{!! Form::textarea('vision', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
									'title' => 'Indique la visión de la institución'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('composition_assets', 'Composición de Patrimonio', []) !!}
								{!! Form::textarea('composition_assets', null, [
									'class' => 'form-control', 'rows' => '4', 'data-toggle' => 'tooltip',
									'title' => 'Indique la composición patrimonial de la institución'
								]) !!}
							</div>
						</div>
					</div>
					<hr>
					<h6 class="md-title">Instituciones Registradas</h6>
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
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
										@if($institution->logo_id)
											<img src="{{ url($institution->logo->url) }}" 
												 alt="logo" class="img-fluid" 
												 style="max-height:50px;">
										@endif
									</td>
									<td>
										<a href="#">{{ $institution->rif }}</a>
									</td>
									<td>{{ $institution->onapre_code }}</td>
									<td>
										@if ($institution->acronym)
											{{ $institution->acronym }} - 
										@endif
										{{ $institution->name }}
									</td>
									<td class="text-center">
										{{ ($institution->active)?'SI':'NO' }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>