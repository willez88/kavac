@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Finanza
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configuración General</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<finance-banks></finance-banks>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de agencias bancarias" 
							   data-toggle="tooltip">
								<i class="icofont icofont-business-man ico-3x"></i>
								<span>Agencias<br>Bancarias</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de tipos de cuenta bancaria" 
							   data-toggle="tooltip">
								<i class="icofont icofont-mathematical ico-3x"></i>
								<span>Tipos<br>Cuenta</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de cuentas bancarias" 
							   data-toggle="tooltip">
								<i class="icofont icofont-law-document ico-3x"></i>
								<span>Cuentas<br>Bancarias</span>
							</a>
						</div>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
							   href="#" title="Registros de chequeras" data-toggle="tooltip">
								<i class="icofont icofont-card ico-3x"></i>
								<span>Chequeras</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop