<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Restaurar Registros eliminados</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<form action="" method="get" accept-charset="utf-8">
					<div class="row">
						<div class="col-md-2">
							<b>Filtros</b>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('start_delete_at', old('start_delete_at'), [
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Desde la fecha', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('end_delete_at', old('end_delete_at'), [
			                        'class' => 'form-control', 'placeholder' => 'Fecha',
			                        'title' => 'Hasta la fecha', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons design_app"></i>
			                    </span>
			                    {!! Form::text('module_delete_at', old('module_delete_at'), [
			                        'class' => 'form-control', 'placeholder' => 'Modulo',
			                        'title' => 'Módulo en donde se eliminó', 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							{!! Form::button('Buscar <i class="fa fa-search"></i>', [
                                'class' => 'btn btn-sm btn-info',
                                'data-toggle' => 'tooltip', 'onclick' => '#',
                                'title' => 'Buscar registros eliminados',
                            ]) !!}
						</div>
					</div>
				</form>
				<table class="table table-hover table-striped dt-responsive nowrap datatable">
					<thead>
						<tr class="text-center">
							<th class="col-md-2">Fecha</th>
							<th class="col-md-4">Módulo</th>
							<th class="col-md-4">Registro</th>
							<th class="col-md-2">Acción</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($trashed as $model => $trash)
							@foreach ($trash as $reg)
								<tr>
									<td>{{ $reg->deleted_at->format('d-m-Y') }}</td>
									<td>{{ $model }}</td>
									<td>
										@foreach ($reg->getAttributes() as $attr => $value)
											@if ($attr !== 'created_at' && $attr !== 'updated_at' && $attr !== 'deleted_at' && $attr !== 'id')
												<p>{{ $value }}</p>
											@endif
										@endforeach
									</td>
									<td class="text-center">
										{!! Form::button('<i class="fa fa-check"></i>', [
	                                        'class' => 'btn btn-success btn-xs btn-icon btn-round',
	                                        'data-toggle' => 'tooltip', 
	                                        'onclick' => 'undelete_record("restore/' . Illuminate\Support\Facades\Crypt::encryptString($model) . '/' . $reg->id . '")',
	                                        'title' => 'Restaurar registro',
	                                    ]) !!}
									</td>
								</tr>
							@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>