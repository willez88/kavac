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
				<h6 class="card-title">Desincorporación de Bienes Institucionales</h6>
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

						<div class="col-md-6">
        					<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            					{!! Form::label('date_label', 'Fecha de la Desincorporación', []) !!}
            					<div class="input-group input-sm">
                                	<span class="input-group-addon">
                                    	<i class="now-ui-icons ui-1_calendar-60"></i>
                                	</span>
                                	{!! Form::date('date',(isset($request->date))?$request->date:\Carbon\Carbon::now(),
		            					[
		                					'class' => 'form-control input-sm',
		                					'data-toggle' => 'tooltip',
		                					'title' => 'Fecha de la desincorporación'
		            					]
		        					) !!}
                            	</div>
    					    </div>
    					</div>
    					<div class="col-md-6">
							<div class="form-group{{ $errors->has('motive') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('motive_label', 'Motivo de la Desincorporación', []) !!}
								{!! Form::select('motive_id', (isset($motive))?$motive:[],
								(isset($request->motive_id))?$request->motive_id:null, [		
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el motivo de la desincorporación del bien'
								]) !!}
								
							</div>
						</div>
					    <div class="col-md-6">
					        <div class="form-group{{ $errors->has('observation') ? ' has-error' : '' }} is-required">
					            {!! Form::label('observation_label', 'Observaciones generales', []) !!}
					            {!! Form::text('observation',(isset($request))?$request->observation:old('observation'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique '
					                ]
					            ) !!}
					        </div>
					    </div>
					</div>

					<div class="row">

						<div class="col-md-12">
							<b>Información de los Bienes a ser Desincorporados</b>
						</div>
						<div class="col-md-4">
							<div class="form-group   {{ $errors->has('type') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('type_label', 'Tipo de Bien', []) !!}
								{!! Form::select('type', (isset($types))?$types:[], (isset($request))?$request->type:null, [		
									'id' => 'type',
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique el tipo de bien a registrar',
									
								]) !!}
								
							</div>
						</div>
											
						<div class="col-md-4">
							<div class="form-group  {{ $errors->has('category') ? ' has-error' : '' }} is-required">

								{!! Form::label('category_label', 'Categoria General', []) !!}
								{!! Form::select('category', (isset($categories))?$categories:[],  (isset($request))?$request->category:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group  {{ $errors->has('subcategory') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('subcategory_label', 'Subcategoria', []) !!}
								{!! Form::select('subcategory', (isset($subcategories))?$subcategories:[],  (isset($request))?$request->subcategory:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la subcategoria del bien'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group  {{ $errors->has('specific_category') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('specific_category_label', 'Categoria Específica', []) !!}
								{!! Form::select('specific_category', (isset($specific_categories))?$specific_categories:[],  (isset($request))?$request->specific_category:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria específica del bien'
								]) !!}

							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group col-md-2 float-right">
							    <button type="Submit" 
							    		@if ($type_search == 1)
							    		formaction ="../../../asset/disincorporations/create"
							    		@endif
							    		@if ($type_search == 2)
							    		formaction ="../../../asset/disincorporations/edit/{{$request->id}}"
							    		@endif
							    		formmethod="GET" 
							    		class='btn btn-sm btn-info' 
							    		data-toggle="tooltip"
							    		title="Buscar registros">
									<i class="fa fa-search"></i>
									<span>	Buscar	</span>
								</button>

							</div>
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
		prueba = [<?php echo ($select); ?>];
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
	alert(seleccionados.length);
	if(seleccionados.length == 0){
	    alert("No ha seleccionado ningún elemento");
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

</script>
@stop