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
					<h6 class="card-title">Bienes Institucionales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">

									<th>Código</th>
									<th>Ubicación</th>
									<th>Condición Física</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>

									<th width="10%">Acciones</th>
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
										
										<td width="10%" class="text-center">
											<div class="d-inline-flex">

											{{-- 	<button onclick="openmodal( <?php echo($asset->id) ?> );" 
                                                        class="btn btn-info btn-xs btn-icon btn-action"  
                                                data-toggle="tooltip" title="Informacion Bien">
                                                    <i class="fa fa-info-circle"></i>
                                                </button> --}}
												
												@if ($asset->status_id == 10)
												{!! Form::open(['route' => ['asset.asignation.asset_assign', $asset], 'method' => 'GET']) !!}
												<button class="btn btn-primary btn-xs btn-icon btn-action"  
												data-toggle="tooltip" title="Asignar Bien">
													<i class="fa fa-filter"></i>
												</button>
												{!! Form::close() !!}
												@endif

												@if (($asset->status_id < 6) || ($asset->status_id > 9))
												{!! Form::open(['route' => ['asset.disincorporation.asset_disassign', $asset->id], 'method' => 'GET']) !!}
												<button class="btn btn-primary btn-xs btn-icon btn-action"  
												data-toggle="tooltip" title="Desincorporar Bien">
													<i class="fa fa-filter"></i>
												</button>
												{!! Form::close() !!}
												@endif

												{!! Form::open(['route' => ['asset.edit', $asset], 'method' => 'GET']) !!}

												<button class="btn btn-warning btn-xs btn-icon btn-action"  
												data-toggle="tooltip" title="Editar Información del Bien">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.destroy', $asset], 'method' => 'DELETE']) !!}
													<button class="btn btn-danger btn-xs btn-icon btn-action"  data-toggle="tooltip" title="Eliminar Bien"><i class="fa fa-trash"></i></button>
												{!! Form::close() !!}
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<div class="modal fade" tabindex="-1" role="dialog" id="add_asset">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6>
					<i class="icofont icofont-read-book ico-2x"></i> 
					Información del Bien Registrado
				</h6>
			</div>
					
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Tipo</label>
							<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_type"
								disabled="true">
						</div>			        	
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Categoria</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_category"
								disabled="true">
			            </div>
			        </div>

			        <div class="col-md-6">
						<div class="form-group">
							<label>Subcategoria</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_subcategory"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Categoria Especifica</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_specific"
								disabled="true">
						</div>
					</div>
			                
					<div class="col-md-6">
						<div class="form-group">
							<label>Código</label>
							<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_codigo"
								disabled="true">
						</div>
					</div>
			                
					<div class="col-md-6">
						<div class="form-group">
							<label>Forma de Adquisición</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_purchase"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Año de Adquisición</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_purchase_year"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Ubicación</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_ubication"
								disabled="true">
						</div>
					</div>
			                
			        <div class="col-md-6">
						<div class="form-group">
							<label>Proveedor</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_proveedor"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Condición Física</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_condition"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Estatus de Uso</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_status"
								disabled="true">
						</div>
					</div>
			                
			        <div class="col-md-6">
						<div class="form-group">
							<label>Función de Uso</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_use"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Serial de Fábrica</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_serial"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Marca</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_marca"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Modelo</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_model"
								disabled="true">
						</div>
					</div>
			                

			        <div class="col-md-6">
						<div class="form-group">
							<label>Valor</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_value"
								disabled="true">
						</div>
					</div>
			                

			    </div>
			</div>

	    	<div class="modal-footer">
	        	<button type="button" 
	            	    class="btn btn-warning btn-icon btn-round btn-modal-close" 
	                	data-dismiss="modal"
	                	title="Cancelar y regresar">
	            	<i class="fa fa-ban"></i>
	        	</button>
			</div>
		</div>
	</div>
</div>





@stop

@section('extra-js')
<script type="text/javascript">

var records;
function openmodal($asset) {
	axios.get("asset/info/" + $asset).then(response => {

		records = response.data.record;
		$(".modal-body #asset_type").val( records.type );
		$(".modal-body #asset_category").val( records.category );
		$(".modal-body #asset_subcategory").val( records.subcategory );
		$(".modal-body #asset_specific").val( records.specific );
		$(".modal-body #asset_codigo").val( records.code );

		$(".modal-body #asset_purchase").val( records.purchase );
		$(".modal-body #asset_purchase_year").val( records.year );
		$(".modal-body #asset_ubication").val( records.ubication );
		$(".modal-body #asset_proveedor").val( records.proveedor );
		$(".modal-body #asset_condition").val( records.condition );
		$(".modal-body #asset_status").val( records.status );

		$(".modal-body #asset_use").val( records.use );
		$(".modal-body #asset_serial").val( records.serial );
		$(".modal-body #asset_marca").val( records.marca );
		$(".modal-body #asset_model").val( records.model );
		$(".modal-body #asset_value").val( records.value );
		$("#add_asset").modal("show");

	})
			
}
</script>
@stop