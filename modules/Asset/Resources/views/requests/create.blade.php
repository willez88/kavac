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
					<h6 class="card-title">Solicitud de Bienes</h6>
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

						<div class="col-md-12">
							<div class="form-group   {{ $errors->has('type') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('type_label', 'Tipo de Solicitud', []) !!}
								{!! Form::select('type', (isset($types))?$types:[

									'Prestamo de Equipos (Uso Interno)',
									'Prestamo de Equipos (Uso Externo)',
									'Prestamo de Equipos para Agentes Externos',

								], (isset($request))?$request->type:null, [		
									'id' => 'type',
									'class' => 'form-control select2',
									'onchange' => 'mostrar(this.value);',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de solicitud a realizar',
									
								]) !!}
								
							</div>
						</div>
					</div>

					<div class="row" id="request">

						<div class="col-md-12">
							<b>Datos de la Solicitud</b>
						</div>

						<div class="col-md-6">
						    <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
						        {!! Form::label('date_label', 'Fecha de Solicitud', []) !!}
						        <div class="input-group input-sm">
						            <span class="input-group-addon">
						                <i class="now-ui-icons ui-1_calendar-60"></i>
						            </span>
						            {!! Form::date('date',(isset($date))?$asset_request->created_at:old('created_at'),
						                [
						                    'class' => 'form-control input-sm',
						                    'disabled' => 'true',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Fecha de la solicitud'
						                ]
						            ) !!}
						        </div>
						            
						    </div>
						</div>

						<div class="col-md-6">
						    <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }} is-required">
						        {!! Form::label('motivo_label', 'Motivo de la solicitud', []) !!}
						        {!! Form::text('motivo',(isset($request_motivo))?$request_motivo->motivo:old('motivo'),
						           [
						                'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el motivo de la solicitud'
						            ]
						        ) !!}
						    </div>
						</div>
					</div>

					<div class="row" id="request-2">
						<div class="col-md-6">
					        <div class="form-group {{ $errors->has('delivery_date') ? ' has-error' : '' }}">
					            {!! Form::label('delivery_date_label', 'Fecha de Entrega', []) !!}
					            <div class="input-group input-sm">
					                <span class="input-group-addon">
										<i class="now-ui-icons ui-1_calendar-60"></i>
					                </span>
					                {!! Form::date('delivery_date',(isset($asset_request))?$asset_request->delivery_date:old('delivery_date'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique la fecha de entrega del bien'
					                ]
					            ) !!}
					                            </div>
					            
					        </div>
					    </div>

					    <div class="col-md-6">
					        <div class="form-group {{ $errors->has('ubication') ? ' has-error' : '' }}">
					            {!! Form::label('ubication_label', 'Ubicación', []) !!}
					            {!! Form::text('ubication',(isset($asset_request))?$asset_request->ubication:old('ubication'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique una descripción de la ubicación del bien'
					                ]
					            ) !!}
					            
					        </div>
					    </div>
						
					</div>

					<div class="row" id="request-3">
						<div class="col-md-12">
						    <b>Información de Contacto</b>    
						</div>
						    
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('external_agent_name') ? ' has-error' : '' }}">
						        {!! Form::label('external_agent_name_label', 'Nombre del Agente Externo', []) !!}
						        {!! Form::text('external_agent_name',(isset($asset_request))?$asset_request->agent_name:old('agent_name'),
						            [
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el nombre del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
						
						<div class="col-md-4">
						    <div class="form-group {{ $errors->has('external_agent_telf') ? ' has-error' : '' }}">
						    	{!! Form::label('external_agent_telf_label', 'Teléfono del Agente Externo', []) !!}
						        {!! Form::text('external_agent_telf',(isset($asset_request))?$asset_request->agent_telf:old('agent_telf'),
						            [
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el teléfono del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('external_agent_email') ? ' has-error' : '' }}">
						    	{!! Form::label('external_agent_email_label', 'Correo del Agente Externo', []) !!}
						        {!! Form::text('external_agent_email',(isset($asset_request))?$asset_request->agent_email:old('agent_email'),
						        	[
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el correo eléctronico del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
					</div>
						
					<div class="row" id= "filtros">
							
						
						<div class="col-md-2">
							<b>Filtros</b>
						</div>

						<div class="form-group col-md-2">
						    <div class="input-group input-sm">
						        <span class="input-group-addon">
						            <i class="now-ui-icons design_app"></i>
						        </span>
						        {!! Form::text('model',(isset($asset))?$asset->model:old('model'),
						            [
						                'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'placeholder' => 'Modelo',
						                'title' => 'Indique el modelo del bien solicitado'
						            ]
						        ) !!}
						    </div>
						</div>

						<div class="form-group col-md-2">
						    <div class="input-group input-sm">
						        <span class="input-group-addon">
						            <i class="now-ui-icons design_app"></i>
						        </span>
						        {!! Form::text('marca',(isset($asset))?$asset->marca:old('marca'),
						            [
						                'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'placeholder' => 'Marca',
						                'title' => 'Indique la marca del bien solicitado'
						            ]
						        ) !!}
						    </div>
						</div>
						    
						<div class="form-group col-md-2">
						    <div class="input-group input-sm">
						        <span class="input-group-addon">
						            <i class="now-ui-icons design_app"></i>
						        </span>
						        {!! Form::text('serial', (isset($asset))?$asset->serial:old('serial'), 
						        	[
						             	'id' => 'serial',
						             	'class' => 'form-control',
						                'data-toggle' => 'tooltip',
						                'placeholder' => 'Serial',
						                'title' => 'Indique el serial del bien solicito'
						            ]
						        ) !!}
						    </div>
						</div>
						    
						<div class="form-group col-md-2">
						    {!! Form::button('Buscar <i class="fa fa-search"></i>', 
						    	[
						            'class' => 'btn btn-sm btn-info',
						            'data-toggle' => 'tooltip', 'onclick' => 'Buscar();',
						            'title' => 'Buscar registros eliminados',
						        ]
						    ) !!}
						</div>
					</div>

					<div id ="table" class="col-md-12">
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
$('#document').ready(function(){
	$('#request').hide();
	$('#request-2').hide();
	$('#request-3').hide();
	$('#filtros').hide();
	$('#table').hide();

});
function mostrar(form_request) {
    if (form_request == "0") {
		$("#request").show();
		$('#request-2').hide();
		$('#request-3').hide();
        $("#filtros").show();
        $("#table").show();
    }
    else if (form_request == "1") {
    	$("#request").show();
    	$('#request-2').show();
    	$('#request-3').hide();
        $("#filtros").show();
        $("#table").show();
        
    }

    else if (form_request == "2") {
        $("#request").show();
        $('#request-2').show();
        $('#request-3').show();
        $("#filtros").show();
        $("#table").show();
    }
    else {
    	$('#request').hide();
    	$('#request-2').hide();
    	$('#request-3').hide();
    	$("#filtros").hide();
    	$("#table").hide();


    }
};

</script>
@stop














