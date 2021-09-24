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
	{{ __('Formulación') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Formulación de Presupuesto') }}
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.print', ['route' => route('print.formulated', ['id' => $formulation->id])])
						@if ($enable)
							@include('buttons.sign', ['route' => route('print.formulatedsign', ['id' => $formulation->id])])
						@endif
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<h5 class="card-title text-center">{{ __('Oficina de programación y Presupuesto') }}</h5>
					<h6 class="card-title text-center">{{ __('Presupuesto de Gastos por Sub Específicas') }}</h6>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">
							{{ ($formulation->assigned)?__('Presupuesto Asignado'):__('Asignar Presupuesto') }}:
						</div>
						<div class="col-9">
							<label>
                                {!! Form::open([
									'route' => ['budget.subspecific-formulations.update', $formulation->id],
									'method' => 'PUT', 'id' => 'form_assign'
								]) !!}
									{!! Form::token() !!}
									{!! Form::checkbox('assigned', true, ($formulation->assigned), [
										'class' => 'form-control bootstrap-switch bootstrap-switch-mini budget-assign',
										'data-on-label' => __('SI'), 'data-off-label' => __('NO'),
										'disabled' => ($formulation->assigned || $formulation->assigned==='1'),
                                        'data-toggle' => 'tooltip', 'title' => __('Asignar presupuesto')
									]) !!}
								{!! Form::close() !!}
							</label>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ __('Institución') }}:</div>
						<div class="col-9">{{ $formulation->specificAction->institution }}</div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ __('Moneda') }}:</div>
						<div class="col-9">{{ $formulation->currency->description }}</div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ __('Presupuesto') }}:</div>
						<div class="col-9">{{ $formulation->year }}</div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ $formulation->specificAction->type }}:</div>
						<div class="col-9 text-justify">
                            {{ $formulation->specificAction->specificable->code }} -
                            {{ $formulation->specificAction->specificable->name }}
                        </div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ __('Acción Específica') }}:</div>
						<div class="col-9">
                            <div class="row">
                                <div class="col-2">{{ $formulation->specificAction->code }} -</div>
                                <div class="col-10 text-justify">
                                    {!! $formulation->specificAction->description !!}
                                </div>
                            </div>
                        </div>
					</div>
					<div class="row form-group">
						<div class="col-3 text-bold text-uppercase">{{ __('Total Formulado') }}:</div>
						<div class="col-9">
							{{ $formulation->currency->symbol }}&#160;
							{{ number_format(
								$formulation->total_formulated, $formulation->currency->decimal_places, ",", "."
							) }}
                        </div>
					</div>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>{{ __('Código') }}</th>
								<th>{{ __('Denominación') }}</th>
								{{-- <th>{{ __('Real') }}</th>
                                <th>{{ __('Estimado') }}</th> --}}
								<th>{{ __('Total Año') }}</th>
								{{-- @foreach (['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'] as $month)
									<th>{{ $month }}</th>
								@endforeach --}}
							</tr>
						</thead>
						<tbody>
							@foreach ($formulation->accountOpens as $accountOpen)
								<tr class="{{ ($accountOpen->budgetAccount->specific==="00")?'text-dark text-bold':'' }}">
									<td>{{ $accountOpen->budgetAccount->code }}</td>
									<td>{{ $accountOpen->budgetAccount->denomination }}</td>
									{{-- <td>{{ $accountOpen->total_real_amount }}</td>
									<td>{{ $accountOpen->total_estimated_amount }}</td> --}}
									<td class="text-right">
										{{ number_format(
											$accountOpen->total_year_amount,
											$formulation->currency->decimal_places, ",", "."
										) }}
									</td>
									{{-- <td>{{ $accountOpen->jan_amount }}</td>
									<td>{{ $accountOpen->feb_amount }}</td>
									<td>{{ $accountOpen->mar_amount }}</td>
									<td>{{ $accountOpen->apr_amount }}</td>
									<td>{{ $accountOpen->may_amount }}</td>
									<td>{{ $accountOpen->jun_amount }}</td>
									<td>{{ $accountOpen->jul_amount }}</td>
									<td>{{ $accountOpen->aug_amount }}</td>
									<td>{{ $accountOpen->sep_amount }}</td>
									<td>{{ $accountOpen->oct_amount }}</td>
									<td>{{ $accountOpen->nov_amount }}</td>
									<td>{{ $accountOpen->dec_amount }}</td> --}}
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
	@parent
	<script>
		$(document).ready(function() {
			@if ($formulation->assigned)
				/**
				 * Muestra un mensaje al usuario en caso de que la formulación de presupuesto
				 * ya se encuentra asignada
				 */
				$.gritter.add({
                    title: '{{ __('Advertencia!') }}',
                    text: '{{ __('Este presupuesto ya se encuentra asignado y no puede ser modificado') }}',
                    class_name: 'growl-danger',
                    image: "{{ asset('images/screen-warning.png') }}",
                    sticky: false,
                    time: 2000
                });
			@endif

			$('.budget-assign').on('switchChange.bootstrapSwitch', function(e) {
				var el = $(this);
				if (el.is(':checked')) {
					bootbox.confirm(
						'{{ __(
                            'Esta seguro de asignar esta formulación?. Una vez asignado no puede ser modificado'
                            )
                        }}',
						function(result) {
							if (result) {
								$("#form_assign").submit();
							}
							else {
								el.is(':checked', false);
                                el.bootstrapSwitch('state', false, true);
							}
						}
					);
				}
			});
		});

        var printFormulated = (id, esp) => {
            location.href = `/budget/print-formulated/${id}`;
            /*axios.get(`/budget/print-formulated/${id}`).catch(error => {
                console.error(error);
            });*/
        };
	</script>
@endsection
