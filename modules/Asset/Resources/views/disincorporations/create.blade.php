@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes Institucionales
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Desincorporación de Bienes Institucionales</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">

						<div class="col-md-6">
							<div class="form-group   {{ $errors->has('type') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('type_label', 'Tipo de Bien', []) !!}
								{!! Form::select('type', (isset($types))?$types:[], (isset($asset))?$asset->type_id:null, [		
									'id' => 'type',
									'class' => 'form-control select2',
									'onchange' => 'mostrar(this.value);',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de bien a registrar',
									
								]) !!}
								
							</div>
						</div>
											
						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('category') ? ' has-error' : '' }} is-required">

								{!! Form::label('category_label', 'Categoria General', []) !!}
								{!! Form::select('category', (isset($categories))?$categories:[],  (isset($asset))?$asset->category_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('subcategory') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('subcategory_label', 'Subcategoria', []) !!}
								{!! Form::select('subcategory', (isset($subcategories))?$subcategories:[],  (isset($asset))?$asset->subcategory_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('specific_category') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('specific_category_label', 'Categoria Específica', []) !!}
								{!! Form::select('specific_category', (isset($specific_categories))?$specific_categories:[],  (isset($asset))?$asset->specific_category_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('asset') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('asset_label', 'Descripción del Bien', []) !!}
								{!! Form::select('asset', (isset($assets))?$assets:[], (isset($disincorporation))?$disincorporation->asset_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el bien a ser asignado'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('ubication') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('ubication_label', 'Ubicación', []) !!}
								{!! Form::select('ubication', (isset($dependencias))?$dependencias:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la dependencia del trabajador al que se le asigna el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('staff') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('staff_label', 'Trabajador', []) !!}
								{!! Form::select('staff', (isset($staffs))?$staffs:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el trabajador activo al que se le asigna el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
        					<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            					{!! Form::label('date_label', 'Fecha de la Desincorporación', []) !!}
            					<div class="input-group input-sm">
                                	<span class="input-group-addon">
                                    	<i class="now-ui-icons ui-1_calendar-60"></i>
                                	</span>
                                	{!! Form::date('date',(isset($date))?$date:\Carbon\Carbon::now(),
		            					[
		                					'class' => 'form-control input-sm',
		                					'data-toggle' => 'tooltip',
		                					'title' => 'Fecha de la desincorporación'
		            					]
		        					) !!}
                            	</div>
    					    </div>
    					</div>
    					<div class="col-md-6">
							<div class="form-group{{ $errors->has('motive') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('motive_label', 'Motivo de la Desincorporación', []) !!}
								{!! Form::select('motive', (isset($motive))?$motive:[],
								(isset($disincorporation))?$disincorporation->motive_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el motivo de la desincorporación del bien'
								]) !!}
								
							</div>
						</div>
					    <div class="col-md-6">
					        <div class="form-group{{ $errors->has('observation') ? ' has-error' : '' }} is-required">
					            {!! Form::label('observation_label', 'Observaciones generales', []) !!}
					            {!! Form::text('observation',(isset($disincorporation))?$disincorporation->observation:old('observation'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique '
					                ]
					            ) !!}
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
