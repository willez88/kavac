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
			{!! (!isset($model))?Form::open($header_asset):Form::model($model, $header_asset) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('asset_type', 'Tipo de Bien', []) !!}
								{!! Form::select('asset_type_id', (isset($asset_type))?$asset_type:[], null, [		
									'class' => 'form-control select2', 'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de bien a registrar',
									'onclick' => 'genAssetType($(this).val())'
								]) !!}
								
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">

								{!! Form::label('category', 'Categoria General', []) !!}
								{!! Form::select('category_id', (isset($categories))?$categories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
								
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('subcategory', 'Subcategoria', []) !!}
								{!! Form::select('subcategory_id', (isset($subcategories))?$subcategories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('specific', 'Categoria Específica', []) !!}
								{!! Form::select('specific_id', (isset($specifics))?$specifics:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('institution', 'Institución', []) !!}
								{!! Form::select('institution_id', (isset($institutions))?$institutions:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la institución donde está alojado el bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('proveedor', 'Proveedor', []) !!}
								{!! Form::select('proveedor_id', (isset($proveedores))?$proveedores:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el proveedor'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('condition', 'Condición Física', []) !!}
								{!! Form::select('condition_id', (isset($conditions))?$conditions:[
									'Óptimo',
									'Regular',
									'Deteriorado',
									'Averiado',
									'Chatarra',
									'No Operativo',
									'Otra Condición Física'
									], null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la condición física del bien'
								]) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('purchase', 'Forma de Adquisición', []) !!}
								{!! Form::select('purchase_id', (isset($purchases))?$purchases:[
									'Compra Directa (Consulta de Precio)',
									'Permuta',
									'Dación en Pago',
									'Donación',
									'Transferencia',
									'Expropiación',
									'Confiscación',
									'Compra por Concurso Abierto',
									'Compra por Concurso Cerrado',
									'Adjudicación'
									], null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la forma de adquisición del bien'
								]) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								
								{!! Form::label('status', 'Estatus de Uso', []) !!}
								{!! Form::select('status_id', (isset($status))?$status:[
									'En Uso',
									'En Comodato',
									'En Arrendamiento',
									'En Mantenimiento',
									'En Reparación',
									'En Proceso de Disposición',
									'En Desuso por Obsolencencia',
									'En Desuso por Inservilidad',
									'En Desuco por Obsolecencia e Inservilidad',
									'En almacen o Depósito para su Asignación',
									'Otro Uso'									
									], null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el estatus de uso del bien'
								]) !!}
								
							</div>
						</div>

						
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('purchase_year') ? ' has-error' : '' }} is-required">
								{!! Form::label('purchase_year_id', 'Año de Adquisición', []) !!}
								{!! Form::number('purchase_year',(isset($asset))?$asset->purchase_year:old('purchase_year'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'placeholder' => '2018',
										'title' => 'Indique el año de adquisición'

								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('serial_id', 'Serial', []) !!}
								{!! Form::text('serial',(isset($asset))?$asset->serial:old('serial'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'title' => 'Indique el serial de fabricación'
									]
								) !!}
								
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group {{ $errors->has('marca') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('marca_id', 'Marca', []) !!}
								{!! Form::text('marca',(isset($asset))?$asset->marca:old('marca'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'title' => 'Indique la marca del bien'
									]
								) !!}


							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('modelo') ? ' has-error' : '' }} is-required">


								{!! Form::label('modelo_id', 'Modelo', []) !!}
								{!! Form::text('modelo',(isset($asset))?$asset->modelo:old('modelo'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'title' => 'Indique el modelo del bien'
									]
								) !!}


							</div>
						</div>



						<div class="col-md-6">
							<div class="form-group {{ $errors->has('value') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('value_id', 'Valor', []) !!}
								{!! Form::number('value',(isset($asset))?$asset->value:old('value'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'placeholder' => '1',
										'title' => 'Indique la cantidad registrada'
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
