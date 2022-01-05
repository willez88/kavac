@extends('asset::layouts.master')

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
					<h6 class="card-title">Reporte de Bienes por Clasificación</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => ['asset.report.create',2], 'id' => 'form1','method' => 'GET', 'role' =>'form']) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">

								{!! Form::label('type_label', 'Tipo de Bien', []) !!}
								{!! Form::select('type', (isset($types))?$types:[], (isset($request->category))?$request->type:null, [
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
								{!! Form::select('category', (isset($categories))?$categories:[],  (isset($request))?$request->category:null, [
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
								{!! Form::select('subcategory', (isset($subcategories))?$subcategories:[],  (isset($request))?$request->subcategory:null, [
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
								{!! Form::select('specific_category', (isset($specific_categories))?$specific_categories:[],  (isset($request))?$request->specific_category:null, [
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
							<button type="Submit" class='btn btn-sm btn-info float-right'>
								<i class="fa fa-search"></i>
								<span>	Buscar	</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-12" align="left">
							<a type="button" href="../../asset/pdf" target='_blank' class='btn btn-sm btn-primary btn-custom'>
								<i class="fa fa-plus-circle"></i>
								<span>	Generar reporte	</span>
							</a>
						</div>
					</div>
					{!! Form::close() !!}
					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">

									<th>Código</th>
									<th>Ubicación</th>
									<th>Condición física</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>
								</tr>
							</thead>
							<tbody>
								@foreach($assets as $asset)
									<tr>
										<td> {{ $asset->serial_inventario }} </td>
								        <td> {{ $asset->institution_id }} </td>
								        <td> {{ $asset->condition->name }} </td>
								        <td> {{ $asset->status->name }} </td>
								        <td> {{ $asset->serial }} </td>
								        <td> {{ $asset->marca }} </td>
										<td> {{ $asset->model }} </td>
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
