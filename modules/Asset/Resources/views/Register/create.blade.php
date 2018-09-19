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
				<h6 class="card-title">Registro Manual</h6>
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
							<div class="form-group  {{ $errors->has('purchase') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('purchase_label', 'Forma de Adquisición', []) !!}
								{!! Form::select('purchase', (isset($purchases))?$purchases:[], (isset($asset))?$asset->purchase_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la forma de adquisición del bien'
								]) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group {{ $errors->has('purchase_year') ? ' has-error' : '' }} is-required">
								{!! Form::label('purchase_year_label', 'Año de Adquisición', []) !!}
								{!! Form::number('purchase_year',(isset($asset))?$asset->purchase_year:old('purchase_year'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el año de adquisición'

								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('institution') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('institution_label', 'Ubicación', []) !!}
								{!! Form::select('institution', (isset($institutions))?$institutions:[],  (isset($asset))?$asset->institution_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la institucion donde recide el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('proveedor') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('proveedor_label', 'Proveedor', []) !!}
								{!! Form::select('proveedor', (isset($proveedores))?$proveedores:[],  (isset($asset))?$asset->proveedor_id:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el proveedor'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('condition') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('condition_label', 'Condición Física', []) !!}
								{!! Form::select('condition', (isset($conditions))?$conditions:[], (isset($asset))?$asset->condition_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la condición física del bien'
								]) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('status') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('status_label', 'Estatus de Uso', []) !!}
								{!! Form::select('status', (isset($status))?$status:[], (isset($asset))?$asset->status_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el estatus de uso del bien'
								]) !!}
								
							</div>
						</div>

						<div id="use_id" class="col-md-6">
							<div class="form-group  {{ $errors->has('use') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('use_label', 'Función de Uso', []) !!}
								{!! Form::select('use', (isset($uses))?$uses:[], (isset($asset))?$asset->use_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la función de uso del bien'
								]) !!}
								
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('serial') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('serial_label', 'Serial', []) !!}
								{!! Form::text('serial',(isset($asset))?$asset->serial:old('serial'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el serial de fabricación'
									]
								) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('marca') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('marca_label', 'Marca', []) !!}
								{!! Form::text('marca',(isset($asset))?$asset->marca:old('marca'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique la marca del bien'
									]
								) !!}


							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('model') ? ' has-error' : '' }} is-required">


								{!! Form::label('modelo_label', 'Modelo', []) !!}
								{!! Form::text('model',(isset($asset))?$asset->model:old('model'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el modelo del bien'
									]
								) !!}


							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group {{ $errors->has('value') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('value_label', 'Valor', []) !!}
								{!! Form::number('value',(isset($asset))?$asset->value:old('value'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el precio del bien'
								]) !!}
								
							</div>
						</div>

						<div id="quantity_id" class="col-md-6">
							<div class="form-group  {{ $errors->has('quantity') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('quantity_label', 'Cantidad', []) !!}
								{!! Form::number('quantity',(isset($asset))?$asset->quantity:old('quantity'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique la cantidad del bien a registrar'
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


@section('extra-js')
<script>
$("#document").ready(function(){
	$("#use_id").hide();
	$("#quantity_id").hide();
});

function mostrar(form_type) {
    if (form_type == "2") {
        $("#use_id").show();
        $("#quantity_id").show();
        
    }
    else{
        $("#use_id").hide();
        $("#quantity_id").hide();
        
    }
}

</script>
@stop