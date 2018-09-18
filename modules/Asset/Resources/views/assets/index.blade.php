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
					<h6 class="card-title">Registro de Bienes Muebles</h6>
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
							<a href="{{ route('asset.assets.create') }}" class='btn btn-sm btn-primary btn-custom float-right'>
								<i class="fa fa-plus-circle"></i>
								<span>	Registrar	</span>
							</a>	
						</div>
					</div>
					
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr class="text-center">
								<th>Tipo de Bien</th>
								<th>Serial</th>
								<th>Marca</th>
								<th>Modelo</th>
								<th>Código de inventario</th>
								<th>Valor</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($assets as $asset)
								<tr>
									<td> {{ $asset->type_id }} </td>
									<td> {{ $asset->serial }} </td>
									<td> {{ $asset->marca }} </td>
									<td> {{ $asset->modelo }} </td>
									<td>  </td>
									<td> {{ $asset->value }} </td>
									<td width="10%" class="text-center">
										<div class="d-inline-flex">
											
											<button class="btn btn-primary btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Asignar bien">
												<i class="fa fa-filter"></i>
											</button>
										
											{!! Form::open(['route' => ['asset.assets.edit', $asset], 'method' => 'GET']) !!}

											<button class="btn btn-warning btn-xs btn-icon btn-round"  
											data-toggle="tooltip" title="Modificar registro">
												<i class="icofont icofont-edit"></i>
											</button>
											{!! Form::close() !!}

											{!! Form::open(['route' => ['asset.assets.destroy', $asset], 'method' => 'DELETE']) !!}
												<button class="btn btn-danger btn-xs btn-icon btn-round"  data-toggle="tooltip" title="Eliminar registro"><i class="fa fa-trash"></i></button>
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
@stop

@section('extra-js')
<script type="text/javascript">
@(document).ready(function{

	

});
</script>
@stop