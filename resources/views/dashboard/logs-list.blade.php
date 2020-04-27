<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">{{ __('Auditoria de Registros') }}</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<form action="" method="get" accept-charset="utf-8">
					<div class="row">
						<div class="col-md-2">
							<b>{{ __('Filtros') }}</b>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('start_date', old('start_date'), [
			                        'class' => 'form-control', 'placeholder' => __('Desde'),
			                        'title' => __('Fecha de inicio de la consulta'), 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons ui-1_calendar-60"></i>
			                    </span>
			                    {!! Form::date('end_date', old('end_date'), [
			                        'class' => 'form-control', 'placeholder' => __('Hasta'),
			                        'title' => __('Fecha final de la consulta'), 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons users_circle-08"></i>
			                    </span>
			                    {!! Form::text('user', old('user'), [
			                        'class' => 'form-control', 'placeholder' => __('Usuario'),
			                        'title' => __('Consulta por usuario'), 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							<div class="input-group input-sm">
			                    <span class="input-group-addon">
			                        <i class="now-ui-icons design_app"></i>
			                    </span>
			                    {!! Form::text('module', old('module'), [
			                        'class' => 'form-control', 'placeholder' => __('Modulo'),
			                        'title' => __('Consulta por módulo de la aplicación'), 'data-toggle' => 'tooltip'
			                    ]) !!}
			                </div>
						</div>
						<div class="form-group col-md-2">
							{!! Form::button('<i class="fa fa-search"></i>', [
                                'class' => 'btn btn-info btn-icon btn-xs px-3',
                                'data-toggle' => 'tooltip', 'onclick' => '#',
                                'title' => __('Buscar registros del sistema'),
                            ]) !!}
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-12">
						<span class="text-muted">
							{{ __(
                                'A continuación se muestran los registros de las más recientes acciones en la ' .
                                'aplicación. Si desea obtener mayor información, debe indicar los parámetros ' .
                                'de búsqueda.'
                            ) }}
						</span>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-success" title="{{ __('Registros nuevos') }}"
						   data-toggle="tooltip"></i>
						<span>{{ __('nuevos') }}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-warning" title="{{ __('Registros actualizados') }}"
						   data-toggle="tooltip"></i>
						<span>{{ __('actualizados') }}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-info" title="{{ __('Registros reestablecidos') }}"
						   data-toggle="tooltip"></i>
						<span>{{ __('restaurados después de eliminación') }}</span>
					</div>
				</div>
				<div class="row mg-bottom-20">
					<div class="col-md-4 panel-legend">
						<i class="ion-android-checkbox-blank text-danger" title="{{ __('Registros eliminados') }}"
						   data-toggle="tooltip"></i>
						<span>{{ __('eliminados') }}</span>
					</div>
				</div>
				@php
                	$auditables = OwenIt\Auditing\Models\Audit::orderBy('id', 'desc')->take(40)->get();
                @endphp
				<table class="table table-hover table-striped dt-responsive nowrap datatable">
					<thead>
						<tr class="text-center">
							<th class="col-1"></th>
							<th class="col-2">{{ __('Fecha') }} - {{ __('Hora') }}</th>
							<th class="col-1">{{ __('IP') }}</th>
							<th class="col-4">{{ __('Módulo') }}</th>
							<th class="col-2">{{ __('Usuario') }}</th>
							<th class="col-2">{{ __('Acción') }}</th>
							<!--<th>URL</th>
							<th>Datos anteriores</th>
							<th>Datos nuevos</th>-->
						</tr>
					</thead>
					<tbody>
						@foreach ($auditables as $audit)
							@if ($audit->user_id !== null)
								@php
									$registerClass = ($audit->event == 'created')?'text-success':'';
									$registerClass = ($audit->event == 'deleted')?'text-danger':$registerClass;
									$registerClass = ($audit->event == 'restored')?'text-info':$registerClass;
									$registerClass = ($audit->event == 'updated')?'text-warning':$registerClass;

									$badgeClass = str_replace('text', 'badge', $registerClass);
								@endphp
								<tr>
									<th>
										<i class="ion-android-checkbox-blank {{ $registerClass }}"></i>
									</th>
									<td>{{ $audit->created_at->format('d-m-Y h:i:s A') }}</td>
									<td>{{ $audit->ip_address }}</td>
									<td>{{ $audit->auditable_type }}</td>
									{{-- <td>{{ trim($audit->url, "?") }}</td> --}}
									<td>
										@php
											$model_user = $audit->user_type;
											$user = $model_user::find($audit->user_id);
										@endphp
										<b>Nombre:</b> {{ ($user) ? $user->name : '' }}<br>
										<b>Usuario:</b> {{ ($user) ? $user->username : '' }}
									</td>
									{{-- <td>
										@if (empty($audit->old_values))
											N/A
										@else
											@foreach ($audit->old_values as $key => $value)
												<b>{{ $key }}:</b> {{ $value }}
												@if (!$loop->last) <br> @endif
											@endforeach
										@endif
									</td>
									<td>
										@if (empty($audit->new_values))
											N/A
										@else
											@foreach ($audit->new_values as $key => $value)
												<b>{{ $key }}:</b> {{ $value }}
												@if (!$loop->last) <br> @endif
											@endforeach
										@endif
									</td> --}}
									<td class="text-center">
										{!! Form::button('<i class="fa fa-eye"></i>', [
	                                        'class' => 'btn btn-info btn-xs btn-icon btn-action',
	                                        'data-toggle' => 'tooltip',
	                                        'onclick' => '$("#modalAudit' . $audit->id . '").modal("show")',
	                                        'title' => __('Ver detalles del registro'),
	                                    ]) !!}
	                                    <div class="modal fade" id="modalAudit{{ $audit->id }}" tabindex="-1"
	                                    	 role="dialog" aria-hidden="true">
	                                    	<div class="modal-dialog" role="document" style="max-width:80%">
	                                    		<div class="modal-content">
	                                    			<div class="modal-header">
	                                    				<h4 style="margin-top:0">{{ __('Registro') }}</h4>
	                                    				<button type="button" class="close btn btn-default"
	                                    						data-dismiss="modal" aria-label="Close">
	                                    					<span aria-hidden="true">&times;</span>
	                                    				</button>
	                                    			</div>
	                                    			<div class="modal-body">
	                                    				<div class="row text-justify">
	                                    					<div class="col-12">
	                                    						<p>
                                    								<span class="badge {{ $badgeClass }}"
                                    									  style="margin-right:10px">
                                    									  	@if ($audit->event == 'created')
                                    									  		{{ __('NUEVO') }}
		                                    								@elseif ($audit->event == 'deleted')
																				{{ __('ELIMINADO') }}
		                                    								@elseif ($audit->event == 'restored')
																				{{ __('RESTAURADO') }}
		                                    								@elseif ($audit->event == 'updated')
																				{{ __('ACTUALIZADO') }}
		                                    								@endif
                                    								</span>
                                    							</p>
	                                    					</div>
	                                    				</div>
	                                    				<div class="row">
	                                    					<div class="col-md-6 text-left">
	                                    						<h5>{{ __('Datos Anteriores') }}</h5>
	                                    						<div>
	                                    							@if (empty($audit->old_values))
		                                    							{{ __('N/A') }}
		                                    						@else
		                                    							@foreach ($audit->old_values as $key => $value)
		                                    								<b>{{ $key }}:</b> {{ $value }}
		                                    								@if (!$loop->last) <br> @endif
		                                    							@endforeach
		                                    						@endif
	                                    						</div>
	                                    					</div>
	                                    					<div class="col-md-6 text-left">
	                                    						<h5>{{ __('Datos nuevos') }}</h5>
	                                    						<div>
	                                    							@if (empty($audit->new_values))
																		{{ __('N/A') }}
																	@else
																		@foreach ($audit->new_values as $key => $value)
																			<b>{{ $key }}:</b> {{ $value }}
																			@if (!$loop->last) <br> @endif
																		@endforeach
																	@endif
	                                    						</div>
	                                    					</div>
	                                    				</div>
	                                    				<div class="modal-footer">
	                                    					<button class="btn btn-primary"
	                                    							data-dismiss="modal"
	                                    							aria-label="Close">
	                                    						{{ __('Cerrar') }}
	                                    					</button>
	                                    				</div>
	                                    			</div>
	                                    		</div>
	                                    	</div>
	                                    </div>
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
