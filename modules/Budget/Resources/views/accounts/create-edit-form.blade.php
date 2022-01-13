@extends('budget::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	{{ __('Presupuesto') }}
@stop

@section('maproute-title')
	{{ __('Catálogo de Cuentas') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Cuenta Presupuestaria') }}
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">{{ __('Cuenta') }}</label>
									{!! Form::select('parent_id', $budget_accounts, null, [
										'class' => 'select2', 'data-toggle' => 'tooltip', 'id' => 'parent_id',
										'title' => __('Seleccione una cuenta presupuestaria')
									]) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">{{ __('Código') }}</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! Form::text('code', old('code'), [
                                                'class' => 'form-control input-sm', 'placeholder' => '0.00.00.00.00',
                                                'data-toggle' => 'tolltip',
                                                'title' => __('Código de la cuenta presupuestaria'),
                                                'data-inputmask' => "'mask': '9.99.99.99.99'"
                                            ]) !!}
                                        </div>
                                    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">{{ __('Denominación') }}</label>
									{!! Form::text('denomination', old('denomination'), [
										'class' => 'form-control input-sm',
                                        'placeholder' => __('descripción de la cuenta'),
										'title' => __('Denominacón o concepto de la cuenta'),
                                        'data-toggle' => 'tooltip',
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="row">
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">{{ __('Recurso') }}</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												{!! Form::radio(
                                                        'account_type', 'resource',
                                                        (isset($model) && $model->resource), [
        													'id' => 'account_type',
                                                            'class' => 'form-control bootstrap-switch',
        													'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                                                        ]
                                                    ) !!}
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">{{ __('Egreso') }}</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												{!! Form::radio(
                                                        'account_type', 'egress',
                                                        (isset($model) && $model->egress), [
        													'id' => 'account_type',
                                                            'class' => 'form-control bootstrap-switch',
        													'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                                                        ]
                                                    ) !!}
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">{{ __('Original') }}</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												{!! Form::checkbox(
                                                        'original', true, (isset($model) && $model->original), [
                                                            'id' => 'original',
                                                            'class' => 'form-control bootstrap-switch',
                                                            'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                                                        ]
                                                    ) !!}
                                                </div>
											</div>
										</div>
									</div>
									<div class="col-3">
										<div class="form-group">
											<label for="" class="control-label">{{ __('Activa') }}</label>
											<div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
    												{!! Form::checkbox(
                                                        'active', true, (isset($model) && $model->active), [
        													'id' => 'active', 'class' => 'form-control bootstrap-switch',
        													'data-on-label' => __('SI'), 'data-off-label' => __('NO'),
                                                            'checked' => true
                                                        ]
                                                    ) !!}
                                                </div>
											</div>
										</div>
									</div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="" class="control-label">{{ __('Afecta Impuesto') }}</label>
                                            <div class="col-12">
                                                <div class="col-12 bootstrap-switch-mini">
                                                    {!! Form::checkbox(
                                                        'disaggregate_tax', true,
                                                        (isset($model) && $model->disaggregate_tax), [
                                                            'id' => 'disaggregate_tax',
                                                            'class' => 'form-control bootstrap-switch',
                                                            'data-on-label' => __('SI'), 'data-off-label' => __('NO'),
                                                            'checked' => true
                                                        ]
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
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
	@parent
	<script>
		$(document).ready(function() {
			/** Genera una nueva cuenta a partir de la cuenta seleccionada */
			$("#parent_id").on('change', function() {
				$("input[type=text]").each(function() {
					$(this).val("");
				});

				if ($(this).val()) {
					axios.get(window.app_url + '/budget/set-children-account/' + $(this).val()).then(response => {
						if (response.data.result) {
							let new_account = response.data.new_account;
							/** Genera las nuevas cuentas */
                            $("input[name=code]").val(
                                `${new_account.group}
                                 ${new_account.item}
                                 ${new_account.generic}
                                 ${new_account.specific}
                                 ${new_account.subspecific}`
                            );
							$("input[name=denomination]").val(new_account.denomination);
							$("input[value=egress]").bootstrapSwitch("state", new_account.egress);
							$("input[value=resource]").bootstrapSwitch("state", new_account.resource);
						}
					}).catch(error => {
						log('budget::accounts.create-edit-form', 181, error);
					});
				}
			});
		});
	</script>
@stop
