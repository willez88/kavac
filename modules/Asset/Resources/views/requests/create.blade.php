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
					<h6 class="card-title">Nueva Solicitud</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>

				
				<div class="card-body">
					
					<div class="row">
						<label class="control-label col-8">Tipo de Solicitud</label>
						<div class="col-8">	
							<select id="request" name="request" 
												 onChange="" 
												 title="Indique el tipo de soicitud a realizar"
												 toggle="tooltip">
						        <option value="0" selected>Seleccione...</option>
						        <option value="1">Prestamo de Equipos (Uso Interno)</option>
						        <option value="2">Prestamo de Equipos (Uso Externo)</option>
						        <option value="3">Prestamo de Equipos para Agentes Externos</option>
						     </select>
						</div>
					</div>
					<br>

					
				</div>
			</div>




		</div>
	</div>
@stop


@section('extra-js')
<script>


</script>
@stop