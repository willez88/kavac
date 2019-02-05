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
						<finance-banking-agencies></finance-banking-agencies>
						<finance-account-types></finance-account-types>
						<finance-bank-accounts></finance-bank-accounts>
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