@extends('finance::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Finanzas
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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['id' => 'form-codes', 'route' => 'finance.setting.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Cheques</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('checks_code', 'Código de cheques emitidos', []) !!}
									{!! Form::text('checks_code', ($checkCode) ? $checkCode->format_code : old('checks_code'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de la emisión de cheques',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($checkCode) ? true : false
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
					<h6 class="card-title">Configuración General</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<finance-banks></finance-banks>
						<finance-banking-agencies></finance-banking-agencies>
						<finance-account-types></finance-account-types>
						<finance-bank-accounts></finance-bank-accounts>
						<finance-checkbooks></finance-checkbooks>
						<div class="col-md-2 text-center">
							<a class="btn-simplex btn-simplex-md btn-simplex-primary"
							   href="{{ route('finance.voucher.design') }}" title="Diseñador de voucher"
							   data-toggle="tooltip" >
								<i class="icofont icofont-rulers-alt ico-3x"></i>
								<span>Diseñador<br>Voucher</span>
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
					<h6 class="card-title">Registros comunes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-2 text-center">
						<finance-payment-methods></finance-payment-methods>
						</div>
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
