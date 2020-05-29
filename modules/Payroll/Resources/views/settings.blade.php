@extends('payroll::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card" id="codeSettingForm">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Formatos de Códigos') }}
						@include('buttons.help', [
							'helpId' => 'PayrollCodeSetting',
							'helpSteps' => get_json_resource('ui-guides/settings/code_settings.json', 'payroll')
						])
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => 'payroll.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Personal</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4" id="staffsCode">
								<div class="form-group">
									{!! Form::label('staffs_code', 'Código del personal', []) !!}
									{!! Form::text('staffs_code', ($sCode) ? $sCode->format_code : old('staffs_code'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del personal',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($sCode) ? true : false
									]) !!}
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-12">
								<h6>Nómina</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4" id="salaryScalesCode">
								<div class="form-group">
									{!! Form::label('salary_scales_code','Código de los escalafones salariales',[]) !!}
									{!! Form::text('salary_scales_code', ($ssCode)
											? $ssCode->format_code
											: old('salary_scales_code'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de los escalafones salariales',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($ssCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-4" id="salaryTabulatorsCode">
								<div class="form-group">
									{!! Form::label('salary_tabulators_code','Código de los tabuladores salariales',[]) !!}
									{!! Form::text('salary_tabulators_code', ($stCode)
											? $stCode->format_code
											: old('salary_tabulators_code'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de los tabuladores salariales',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($stCode) ? true : false
									]) !!}
								</div>
							</div>
						</div>

						@include('layouts.help-text', ['codeSetting' => true])
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configuración de la Edad Laboral Permitida</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{!! Form::open(['route' => 'parameters.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									@if (Modules\Payroll\Models\Parameter::where([
							            'active' => true, 'required_by' => 'payroll',
							            'p_key' => 'work_age'
							        ])->first())
										{!! Form::label('p_value', 'Edad', []) !!}
										{!! Form::number('p_value', ($parameter) ? $parameter->p_value : old('p_value'), [
											'class' => 'form-control', 'data-toggle' => 'tooltip',
											'title' => 'Indique la edad laboral permitida', 'min' => '1',
											'placeholder' => 'Edad'
										]) !!}
									@endif
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
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registros Comúnes</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de tipos de personal --}}
						<payroll-staff-types></payroll-staff-types>

						{{-- Configuración de tipos de cargos --}}
						<payroll-position-types></payroll-position-types>

						{{-- Configuración de cargos --}}
						<payroll-positions></payroll-positions>

						{{-- Configuración de clasificación del personal --}}
						<payroll-staff-classifications></payroll-staff-classifications>

						{{-- Configuración del grado de instrucción --}}
						<payroll-instruction-degrees></payroll-instruction-degrees>

						{{-- Configuración del tipo de estudio --}}
						<payroll-study-types></payroll-study-types>

						{{-- Configuración de la nacionalidad --}}
						<payroll-nationalities></payroll-nationalities>

						{{-- Tipo de concepto --}}
						{{--
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.concept-types.index') }}" title="Registro de tipos de concepto"
							   data-toggle="tooltip">
								<i class="icofont icofont-plus ico-3x"></i>
								<span>Tipos de<br>Concepto</span>
							</a>
						</div>
						--}}

						{{-- nivel de idioma --}}
						<payroll-language-levels></payroll-language-levels>

						{{-- idioma --}}
						<payroll-languages></payroll-languages>

						{{-- género --}}
						<payroll-genders></payroll-genders>

						{{-- tipos de inactividad --}}
						<payroll-inactivity-types></payroll-inactivity-types>

						{{-- tipos de contrato --}}
						<payroll-contract-types></payroll-contract-types>

						{{-- tipos de sector --}}
						<payroll-sector-types></payroll-sector-types>

						{{-- grados de licencia de conducir --}}
						<payroll-license-degrees></payroll-license-degrees>

						{{-- tipos de sangre --}}
						<payroll-blood-types></payroll-blood-types>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Parámetros Generales de Nómina</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Parámetros de Nómona --}}
						<payroll-parameters></payroll-parameters>

						{{-- Escalafones Salariales --}}
						<payroll-salary-scales></payroll-salary-scales>

						{{-- Tabuladores de Nómina --}}
						<payroll-salary-tabulators></payroll-salary-tabulators>

						{{-- Tipos de Conceptos --}}
						<payroll-concept-types></payroll-concept-types>

						{{-- Conceptos --}}
						<payroll-concepts></payroll-concepts>

						{{-- Tipos de Pago --}}
						<payroll-payment-types></payroll-payment-types>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
    @parent
    {!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
@stop
