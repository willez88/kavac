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
	Gestión de Bienes
@stop

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Categorías de Bienes</h6>
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

						<div class="col-md-4">
							<div class="form-group">
								
								{!! Form::label('asset_type_id', 'Tipo de Bien', []) !!}
								
								{!! Form::select('Asset_type', (isset($asset_type))?$asset_type:[], null, [		
									'class' => 'form-control select2', 'data-toggle' => 'tooltip',
									'title' => 'Indique el tipo de bien a registrar',
									'onclick' => 'mostrar($(this).val())'
								]) !!}
																
							</div>
						</div>
					</div>
					<div class="row">
							
						<div class="col-md-4">
							<div class="form-group">

								{!! Form::label('category_old', 'Categoria General', []) !!}
								{!! Form::select('Category', (isset($categories))?$categories:[], null, [
									
				
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}

								{!! Form::label('category_new_id', 'Nueva categoria', []) !!}
								{!! Form::text('New_category',null,['class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique una nueva categoria general'
								]) !!}	
								
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								
								{!! Form::label('subcategory_old_id', 'Subcategoria', []) !!}
								{!! Form::select('Subcategory', (isset($subcategories))?$subcategories:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}

								{!! Form::label('subcategory_new_id', 'Nueva Subcategoria', []) !!}
								{!! Form::text('New_subcategory',null,['class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique una nueva subcategoria'
								]) !!}

							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								
								{!! Form::label('specific_old_id', 'Categoria Específica', []) !!}
								{!! Form::select('Specific_category', (isset($specifics))?$specifics:[], null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}

								{!! Form::label('Specific_new_id', 'Nueva Categoria Especifica', []) !!}
								{!! Form::text('New_specific_category',null,['class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'title' => 'Indique una nueva subcategoria Específica'
								]) !!}
								

							</div>
						</div>					

					</div>

				</div>
				<asset-clasifications-list route_list='#' 
										  	route_delete="#" 
										  	route_edit="#">
				</asset-clasifications-list>

				
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
				{!! Form::close() !!}
		</div>

	</div>

</div>

@stop


@section('extra-js')

<script type="text/javascript">

	$(document).ready(function(){


	});
	function mostrar(id){
		console.log(id);
	}


</script>
	
@stop