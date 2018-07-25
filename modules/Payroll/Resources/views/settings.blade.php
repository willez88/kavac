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
							   href="{{ route('staff-types.index') }}" title="Registro de tipos de personal" data-toggle="tooltip">
								<i class="icofont icofont-people ico-3x"></i>
								<span>Tipos de<br>Personal</span>
							</a>
						</div>
						{{-- Configuración de cargos --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('positions.index') }}" title="Registro de cargos"
							   data-toggle="tooltip">
								<i class="icofont icofont-briefcase-alt-1 ico-3x"></i>
								<span>Cargos</span>
							</a>
						</div>
						{{-- Configuración de tipos de cargos --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="#" title="Registro de tipos de cargos"
							   data-toggle="tooltip">
								<i class="icofont icofont-contact-add ico-3x"></i>
								<span>Tipos de<br>Cargos</span>
							</a>
						</div>
						{{-- Configuración de clasificación del personal --}}
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="#" title="Registro de clasificación del personal"
							   data-toggle="tooltip">
								<i class="icofont icofont-company ico-3x"></i>
								<span>Clasificación<br>del Personal</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop