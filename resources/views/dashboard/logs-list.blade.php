<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Bitácora de registros</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" 
					   title="Minimizar" data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			<div class="card-body">
				<form action="dashboard-2_submit" method="get" accept-charset="utf-8">
					<div class="row">
						<div class="col-md-2">
							<b>Filtros</b>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('start_date', old('start_date'), [
			                        'class' => 'form-control', 'placeholder' => 'Desde',
			                        'title' => 'Fecha de inicio de la consulta', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('end_date', old('end_date'), [
			                        'class' => 'form-control', 'placeholder' => 'Hasta',
			                        'title' => 'Fecha final de la consulta', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons users_circle-08"></i>
			                    </span>
			                    {!! Form::text('user', old('user'), [
			                        'class' => 'form-control', 'placeholder' => 'Usuario',
			                        'title' => 'Consulta por usuario', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons design_app"></i>
			                    </span>
			                    {!! Form::text('module', old('module'), [
			                        'class' => 'form-control', 'placeholder' => 'Modulo',
			                        'title' => 'Consulta por módulo de la aplicación', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							{!! Form::button('Buscar <i class="fa fa-search"></i>', [
                                'class' => 'btn btn-sm btn-info',
                                'data-toggle' => 'tooltip', 'onclick' => '#',
                                'title' => 'Buscar registros del sistema',
                            ]) !!}
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-12">
						<span class="text-muted">
							A continuación se muestran los registros de las más recientes acciones en la aplicación. Si desea obtener mayor información, debe indicar los parámetros de búsqueda.
						</span>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-success" title="Registros nuevos" 
						   data-toggle="tooltip"></i>
						<span>nuevos</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-warning" title="Registros actualizados" 
						   data-toggle="tooltip"></i>
						<span>actualizados</span>
					</div>
				</div>
				<div class="row mg-bottom-20">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-danger" title="Registros eliminados" 
						   data-toggle="tooltip"></i>
						<span>eliminados</span>
					</div>
				</div>
				<table class="table table-hover table-striped dt-responsive nowrap datatable">
					<thead>
						<tr class="text-center">
							<th>Fecha - Hora</th>
							<th>Módulo</th>
							<th>ID</th>
							<th>Tipo</th>
							<th>Usuario</th>
							<th>Datos anteriores</th>
							<th>Datos nuevos</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>