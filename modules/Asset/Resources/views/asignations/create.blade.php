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
				<h6 class="card-title">Asignación de Bienes Institucionales</h6>
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
							<div class="form-group">
								
								{!! Form::label('type_label', 'Tipo de Bien', []) !!}
								{!! Form::select('asset_type', (isset($types))?$types:[], null, [		
									'class' => 'form-control select2', 'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de bien a registrar',
									
								]) !!}
								
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">

								{!! Form::label('category_label', 'Categoria General', []) !!}
								{!! Form::select('asset_category', (isset($categories))?$categories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('subcategory_label', 'Subcategoria', []) !!}
								{!! Form::select('asset_subcategory', (isset($subcategories))?$subcategories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('specific_category_label', 'Categoria Específica', []) !!}
								{!! Form::select('asset_specific_category', (isset($specific_categories))?$specific_categories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('asset_label', 'Descripción del Bien', []) !!}
								{!! Form::select('asset', (isset($assets))?$assets:[], (isset($asignation))?$asignation->asset_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el bien a ser asignado'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('ubication_label', 'Ubicación', []) !!}
								{!! Form::select('asset_ubication', (isset($dependencias))?$dependencias:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la dependencia del trabajador al que se le asigna el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('staff_label', 'Trabajador', []) !!}
								{!! Form::select('staff', (isset($staffs))?$staffs:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el trabajador activo al que se le asigna el bien'
								]) !!}

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
