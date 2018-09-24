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
					<h6 class="card-title">Reporte de Bienes Institucionales por Clasificación</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{!! Form::open(['route' => ['asset.report.index',2], 'id' => 'form1','method' => 'GET', 'role' =>'form']) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
									
								{!! Form::label('type_label', 'Tipo de Bien', []) !!}
								{!! Form::select('type', (isset($types))?$types:[], (isset($asset))?$asset->type_id:null, [		
									'id' => 'type',
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de bien a registrar',
										
								]) !!}
									
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
									
								{!! Form::label('category_label', 'Categoria General', []) !!}
								{!! Form::select('category', (isset($categories))?$categories:[],  (isset($asset))?$asset->category_id:null, [
									'id' => 'category',
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
									
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
									
								{!! Form::label('subcategory_label', 'Subcategoria', []) !!}
								{!! Form::select('subcategory', (isset($subcategories))?$subcategories:[],  (isset($asset))?$asset->subcategory_id:null, [
									'id' => 'subcategory',
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}
									
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
									
								{!! Form::label('specific_category_label', 'Categoria Específica', []) !!}
								{!! Form::select('specific_category', (isset($specific_categories))?$specific_categories:[],  (isset($asset))?$asset->specific_category_id:null, [
									'id' => 'specific_category',
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}
									
							</div>
						</div>






					</div>
					<div class="row">
						<div class="col-12">
							<button type="Submit" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Buscar	</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-12" align="left">
							<button type="Submit" formaction ="../../asset/pdf" class='btn btn-sm btn-primary btn-custom'>
								<i class="fa fa-plus-circle"></i>
								<span>	Imprimir Resultados	</span>
							</button>
						</div>
					</div>
					{!! Form::close() !!}
					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">

									<th>Código</th>
									<th>Tipo</th>
									<th>Categoria</th>
									<th>Subcategoria</th>
									<th>Categoria Específica</th>
									<th>Ubicación</th>
									<th>Proveedor</th>
									<th>Condición Física</th>
									<th>Forma de Adquisición</th>
									<th>Año de Adquisición</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Valor</th>
								</tr>
							</thead>
							<tbody>
								@foreach($assets as $asset)
									<tr>
										<td> {{ $asset->serial_inventario }} </td>
										<td> {{ $asset->type->name }} </td>
								        <td> {{ $asset->category->name }} </td>
								        <td> {{ $asset->subcategory->name }} </td>
								        <td> {{ $asset->specific->name }} </td>
								        <td> {{ $asset->institution_id }} </td>
								        <td> {{ $asset->proveedor_id }} </td>
								        <td> {{ $asset->condition->name }} </td>
								        <td> {{ $asset->purchase->name }} </td>
								        <td> {{ $asset->purchase_year }} </td>
								        <td> {{ $asset->status->name }} </td>
								        <td> {{ $asset->serial }} </td>
								        <td> {{ $asset->marca }} </td>
										<td> {{ $asset->model }} </td>
										<td> {{ $asset->value }} </td>
										
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop