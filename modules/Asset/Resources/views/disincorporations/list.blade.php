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
					<h6 class="card-title">Desincorporación de Bienes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">

					<div class="row">
						<div class="col-12">
							<a href="{{ route('asset.disincorporation.create') }}" class='btn btn-sm btn-primary btn-custom float-right'
								title="Desincorporar un bien Previamente Asignado"
								data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>	Nuevo	</span>
							</a>	
						</div>
					</div>

					<div class="col-md-12">
						<table class="table table-hover table-striped dt-responsive datatable">
							<thead>
								<tr class="text-center">
									<th>Código</th>						
									<th>Descripción del Bien</th>
									<th>Motivo</th>
									<th>Fecha de la Desincorporación</th>
									<th width="10%">Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($asset_disincorporations as $disincorporation)
									<tr>
										<td>{{ $disincorporation->id }}</td>
										<td>{{ $disincorporation->asset->serial }}</td>
										<td>{{ $disincorporation->motive->name }}</td>
										<td class="text-center">{{ $disincorporation->created_at }}</td>
										<td width="10%" class="text-center">
											<div class="d-inline-flex">

												<button onclick="openmodal( <?php echo($disincorporation->id) ?> );" 
												class="btn btn-info btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Ver información de la Desincorporación">
													<i class="fa fa-info-circle"></i>
												</button>
												{!! Form::open(['route' => ['asset.disincorporation.edit', $disincorporation], 'method' => 'GET']) !!}
												<button class="btn btn-warning btn-xs btn-icon btn-round"  
												data-toggle="tooltip" title="Editar información de la Desincorporación">
													<i class="icofont icofont-edit"></i>
												</button>
												{!! Form::close() !!}

												{!! Form::open(['route' => ['asset.disincorporation.destroy', $disincorporation], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar Desincorporación"><i class="fa fa-trash"></i></button>
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


	<div class="modal fade" tabindex="-1" role="dialog" id="add_disincorporation">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h6>
					<i class="icofont icofont-read-book ico-2x"></i> 
					Información de la Desincorporación del Bien
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
							<label>Descripción del Bien</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_descrip"
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
							<label>Trabajador Activo Responsable del Bien</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_staff"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Fecha de la Desincorporación</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_date"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Motivo de la Desincorporación</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_motive"
								disabled="true">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Observaciones Generales</label>
			        		<input type="text"
								data-toggle="tooltip" 
								class="form-control"
								id="asset_observe"
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
function openmodal($disincorporation) {
	axios.get("disincorporations/info/" + $disincorporation).then(response => {
			
		records = response.data.record;
		$(".modal-body #asset_type").val( records.type );
		$(".modal-body #asset_category").val( records.category );
		$(".modal-body #asset_subcategory").val( records.subcategory );
		$(".modal-body #asset_specific").val( records.specific );
		
		$(".modal-body #asset_descrip").val( records.description );
		$(".modal-body #asset_ubication").val( records.ubication );
		$(".modal-body #asset_staff").val( records.staff );
		$(".modal-body #asset_date").val( records.date );
		$(".modal-body #asset_motive").val( records.motive );
		$(".modal-body #asset_observe").val( records.observe );
		$("#add_disincorporation").modal("show");

	})
			
}
</script>
@stop