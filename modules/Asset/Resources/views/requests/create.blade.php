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
							<b>Datos de la Solicitud</b>
						</div>

						<div class="col-md-6">
						    <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
						        {!! Form::label('date_label', 'Fecha de Solicitud', []) !!}
						        <div class="input-group input-sm">
						            <span class="input-group-addon">
						                <i class="now-ui-icons ui-1_calendar-60"></i>
						            </span>
						            {!! Form::date('date',(isset($request->created_at))?$request->created_at:\Carbon\Carbon::now(),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Fecha de la solicitud',
						                    'readonly' => 'readonly',
						                ]
						            ) !!}
						        </div>
						            
						    </div>
						</div>

					
						<div class="col-md-6">
						    <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }} is-required">
						        {!! Form::label('motivo_label', 'Motivo de la solicitud', []) !!}
						        {!! Form::text('motive',(isset($request))?$request->motive:old('motive'),
						           [
						                'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el motivo de la solicitud'
						            ]
						        ) !!}
						    </div>
						</div>

						<div class="col-md-6">
							<div class="form-group   {{ $errors->has('type') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('type_label', 'Tipo de Solicitud', []) !!}
								{!! Form::select('type', (isset($types))?$types:[

									'Seleccione...',
									'Prestamo de Equipos (Uso Interno)',
									'Prestamo de Equipos (Uso Externo)',
									'Prestamo de Equipos para Agentes Externos',

								], (isset($request))?$request->type:$type, [		
									'id' => 'type',
									'class' => 'form-control select2',
									'onchange' => 'mostrar(this.value);',
									'data-toggle' => 'tooltip',
									'title' => 'Indique el tipo de solicitud a realizar',
									
								]) !!}
								
							</div>
						</div>
					</div>
					@if(($type==2) ||($type==3))
					<div class="row" id="request-2">
						<div class="col-md-6">
					        <div class="form-group {{ $errors->has('delivery_date') ? ' has-error' : '' }} is-required">
					            {!! Form::label('delivery_date_label', 'Fecha de Entrega', []) !!}
					            <div class="input-group input-sm">
					                <span class="input-group-addon">
										<i class="now-ui-icons ui-1_calendar-60"></i>
					                </span>
					                {!! Form::date('delivery_date',(isset($request))?$request->delivery_date:old('delivery_date'),
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
					        <div class="form-group {{ $errors->has('ubication') ? ' has-error' : '' }} is-required">
					            {!! Form::label('ubication_label', 'Ubicación', []) !!}
					            {!! Form::text('ubication',(isset($request))?$request->ubication:old('ubication'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique una descripción de la ubicación del bien'
					                ]
					            ) !!}
					            
					        </div>
					    </div>
						
					</div>
					@endif

					@if($type == 3)
					<div class="row" id="request-3">
						<div class="col-md-12">
						    <b>Información de Contacto</b>    
						</div>
						    
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('external_agent_name') ? ' has-error' : '' }} is-required">
						        {!! Form::label('external_agent_name_label', 'Nombre del Agente Externo', []) !!}
						        {!! Form::text('agent_name',(isset($request))?$request->agent_name:old('agent_name'),
						            [
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el nombre del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
						
						<div class="col-md-4">
						    <div class="form-group {{ $errors->has('external_agent_telf') ? ' has-error' : '' }} is-required">
						    	{!! Form::label('external_agent_telf_label', 'Teléfono del Agente Externo', []) !!}
						        {!! Form::text('agent_telf',(isset($request))?$request->agent_telf:old('agent_telf'),
						            [
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el teléfono del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group {{ $errors->has('external_agent_email') ? ' has-error' : '' }} is-required">
						    	{!! Form::label('external_agent_email_label', 'Correo del Agente Externo', []) !!}
						        {!! Form::text('agent_email',(isset($request))?$request->agent_email:old('agent_email'),
						        	[
						            	'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el correo eléctronico del agente externo responsable del bien'
						            ]
						        ) !!}
						            
						    </div>
						</div>
					</div>
					@endif						
						
					<div class="row">
						<div class="col-md-12">
							<b>Seleccione los Bienes a ingresar en la solicitud</b>
						</div>
					</div>
					<div class="row"style="margin: 10px 0">
						<div class="col-md-2">
							<b>Filtros</b>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-2">
						    <div class="input-group input-sm">
						        <span class="input-group-addon">
						            <i class="now-ui-icons design_app"></i>
						        </span>
						        {!! Form::text('model',(isset($asset))?$asset->model:old('model'),
						            [
						                'id' => 'model',
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
						                'id' => 'marca',
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
						    <button type="Submit" 
						    		formaction ="../../../asset/requests/create/{{$type}}"
						    		formmethod="GET" 
						    		class='btn btn-sm btn-info' 
						    		data-toggle="tooltip"
						    		title="Buscar registros">
								<i class="fa fa-search"></i>
								<span>	Buscar	</span>
							</button>

						</div>
					</div>

					<div id ="table" class="col-md-12">
						<table id="table_id" class="table table-hover table-striped dt-responsive">
							<thead>
							    <tr class="text-center">

							        <th><input type="checkbox" name="select_all" id ="select_all" onclick="change()"></th>
							        <th>Código</th>
									<th>Ubicación</th>
									<th>Condición Física</th>
									<th>Estatus de uso</th>
									<th>Serial</th>
									<th>Marca</th>
									<th>Modelo</th>

							    </tr>
							</thead>
							
							<tbody>
							    @foreach($assets as $asset)
							    <tr>
							        
							        <td></td>
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
	var seleccionados=[];
	var selecAll=false;
$(document).ready(function(){
	var table = $('#table_id').DataTable({
		columnDefs: [ {
            orderable: true,
            className: 'select-checkbox',
            targets:   0
        } ],
		dom: 'frtip',
		select: {
			style: 'multi'
		},
		

	});
	@if(isset($select))
		prueba = [<?php echo ($select); ?>]
		prueba[0].forEach( function(valor, indice, array) {
			$('#table_id').DataTable().rows().iterator('row',function(context,index){
				dato = $(this.row(index).node()).find("td:eq(1)").text();

			    if (dato.trim() === valor.trim()){
			    	$(this.row(index).node()).addClass('selected');
		
					if (seleccionados.indexOf(dato) === -1) {
			        	seleccionados.push(dato);
				    }else if (seleccionados.indexOf(dato) > -1) {
				        seleccionados.splice(seleccionados.indexOf(dato), 1);
				    }
			    
			    }
			});
		});	
	@endif
    
    $('#table_id tbody').on( 'click', 'tr', function () {
        dato = $(this).find("td:eq(1)").text();

        if (seleccionados.indexOf(dato) === -1) {
        	seleccionados.push(dato);
	    } else if (seleccionados.indexOf(dato) > -1) {
	        seleccionados.splice(seleccionados.indexOf(dato), 1);
	    }

    } );

    

});


$("#save").on("click", function(event){
	if(seleccionados.length == 0){
	    bootbox.alert("Debe seleccionar almenos un elemento para procesar la solicitud");
	    return false;
	}
    else{
            $('<input>', {
                type: 'hidden',
                value:seleccionados,
                name: 'ids',
                id: 'ids'
            }).appendTo('#form');
         $("#form").submit();
 
        
	};
});
	
function change(){
	$('#table_id').DataTable().rows().iterator('row',function(context,index){
		dato = $(this.row(index).node()).find("td:eq(1)").text();

	    if (selecAll == false){
	    	$(this.row(index).node()).addClass('selected');

			if (seleccionados.indexOf(dato) === -1) {
	        	seleccionados.push(dato);
		    }	    
	    }
	    else{
	    	$(this.row(index).node()).removeClass('selected');
	    	if (seleccionados.indexOf(dato) > -1) {
		        seleccionados.splice(seleccionados.indexOf(dato), 1);
		    }
	    }
	});
	selecAll = !selecAll;
}

function mostrar($form_request) {
	if($form_request>0)
    	window.location.href='/asset/requests/create/'+$form_request;
};



</script>
@stop
