@extends('layouts.app')

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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Formatos de Códigos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
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
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('staffs_code', 'Código de Formulación', []) !!}
									{!! Form::text('staffs_code', ($sCode) ? $sCode->format_code : old('staffs_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del personal',
										'placeholder' => 'Ej. XXX-0000000000-YYYY',
										'readonly' => ($sCode) ? true : false
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
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.staff-types.index') }}" title="Registro de tipos de personal" data-toggle="tooltip">
								<i class="icofont icofont-people ico-3x"></i>
								<span>Tipos de<br>Personal</span>
							</a>
						</div>
						{{-- Configuración de tipos de cargos --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.position-types.index') }}" title="Registro de tipos de cargos"
							   data-toggle="tooltip">
								<i class="icofont icofont-contact-add ico-3x"></i>
								<span>Tipos de<br>Cargos</span>
							</a>
						</div>
						{{-- Configuración de cargos --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.positions.index') }}" title="Registro de cargos"
							   data-toggle="tooltip">
								<i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
								<span>Cargos</span>
							</a>
						</div>
						{{-- Configuración de clasificación del personal --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.staff-classifications.index') }}" title="Registro de clasificación del personal"
							   data-toggle="tooltip">
								<i class="icofont icofont-company ico-3x"></i>
								<span>Clasificación<br>del Personal</span>
							</a>
						</div>
						{{-- Configuración del grado de instrucción --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.instruction-degrees.index') }}" title="Registro del grado de instrucción"
							   data-toggle="tooltip">
								<i class="icofont icofont-graduate-alt ico-3x"></i>
								<span>Grado de<br>Instrucción</span>
							</a>
						</div>
						{{-- Configuración del tipo de estudio --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.study-types.index') }}" title="Registro del tipo de estudio"
							   data-toggle="tooltip">
								<i class="icofont icofont-education ico-3x"></i>
								<span>Tipo de<br>Estudio</span>
							</a>
						</div>
						{{-- Configuración de la nacionalidad --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.nationalities.index') }}" title="Registro de nacionalidades"
							   data-toggle="tooltip">
								<i class="icofont icofont-id-card ico-3x"></i>
								<span>Nacionalidad</span>
							</a>
						</div>
						{{-- Tipo de concepto --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.concept-types.index') }}" title="Registro de tipos de concepto"
							   data-toggle="tooltip">
								<i class="icofont icofont-plus ico-3x"></i>
								<span>Tipos de<br>Concepto</span>
							</a>
						</div>
						{{-- nivel de idioma --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.language-levels.index') }}" title="Registro de nivel de idioma"
							   data-toggle="tooltip">
								<i class="icofont icofont-earth ico-3x"></i>
								<span>Nivel de<br>Idioma</span>
							</a>
						</div>
						{{-- idioma --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.languages.index') }}" title="Registro de idioma"
							   data-toggle="tooltip">
								<i class="icofont icofont-flag ico-3x"></i>
								<span>Idioma</span>
							</a>
						</div>
						{{-- género --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('payroll.genders.index') }}" title="Registro del género del trabajador"
							   data-toggle="tooltip">
								<i class="icofont icofont-group-students ico-3x"></i>
								<span>Género</span>
							</a>
						</div>
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
						{{-- Tabuladores de Nómina --}}
						<payroll-salary-tabulator>
						</payroll-salary-tabulator>

						{{-- Definición de Asignaciones de Nómina --}}
						<payroll-salary-assignment>
						</payroll-salary-assignment>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
