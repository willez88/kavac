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
				<h6 class="card-title">Asignación de Bienes Institucionales</h6>
				<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
			</div>
			{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
				<div class="card-body">
					@include('layouts.form-errors')

					<div class="row">

						<div class="col-md-12">
							<b>Información del Trabajador Responsable del bien</b>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('type_position') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('puesto_work_label', 'Puesto de Trabajo', []) !!}
								{!! Form::select('type_position', (isset($type_positions))?$type_positions:[], null, [
									'class' => 'form-control select2',
									'title' => 'Indique el puesto del trabajador activo'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('cargo_label', 'Cargo', []) !!}
								{!! Form::select('position', (isset($positions))?$positions:[], null, [
									'class' => 'form-control select2',
									'title' => 'Indique el cargo del trabajador activo'
								]) !!}

							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group{{ $errors->has('staff') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('staff_label', 'Trabajador', []) !!}
								{!! Form::select('staff', (isset($staffs))?$staffs:[], null, [
									'class' => 'form-control select2',
									'title' => 'Indique el trabajador activo al que se le asigna el bien'
								]) !!}

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('ubication') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('ubication_label', 'Ubicación', []) !!}
								{!! Form::select('ubication', (isset($dependencias))?$dependencias:[], null, [
									'class' => 'form-control select2',
									'title' => 'Indique la dependencia del trabajador al que se le asigna el bien'
								]) !!}

							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<b>Información de los Bienes a ser Asignados</b>
						</div>
					</div>
					<div class="row" style="margin: 10px 0">
						<div class="col-md-12">
							<b>Filtros</b>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								
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
							<div class="form-group">

								{!! Form::label('category_label', 'Categoria General', []) !!}
								{!! Form::select('category', (isset($categories))?$categories:[],  (isset($request))?$request->category:null, [
									'class' => 'form-control select2',
									'placeholder' => 'Seleccione...',
									'title' => 'Indique la categoria general del bien'
								]) !!}
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								
								{!! Form::label('subcategory_label', 'Subcategoria', []) !!}
								{!! Form::select('subcategory', (isset($subcategories))?$subcategories:[],  (isset($request))?$request->subcategory:null, [
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
						    		formaction ="#"
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

</script>
@stop