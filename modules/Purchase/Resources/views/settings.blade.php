@extends('purchase::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Compra
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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<purchase-supplier-branches></purchase-supplier-branches>
						<purchase-supplier-objects></purchase-supplier-objects>
						<purchase-supplier-specialties></purchase-supplier-specialties>
						<purchase-supplier-types></purchase-supplier-types>
						<required-documents module="purchase" model="supplier"></required-documents>
						<purchase-processes></purchase-processes>
						<purchase-type></purchase-type>
						<purchase-type-hiring></purchase-type-hiring>
						<purchase-type-operations></purchase-type-operations>
					</div>
				</div>
			</div>
		</div>
	</div>
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
				{!! Form::open(['route' => 'purchase.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Compras</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('requirements_code', 'Código de Requerimiento', []) !!}
									{!! Form::text(
										'requirements_code',
										($rqCode)?$rqCode->format_code:old('requirements_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de los requerimientos de compra',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($rqCode) ? true : false
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('quotations_code', 'Código de Cotización', []) !!}
									{!! Form::text(
										'quotations_code',
										($quCode)?$quCode->format_code:old('quotations_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de la cotización',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($quCode) ? true : false
										]
									) !!}
								</div>
							</div>
							@if(!(Module::has('Budget') || !Module::isEnabled('Budget')))
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('states_code', 'Código de estados', []) !!}
									{!! Form::text(
										'states_code',
										($esCode)?$esCode->format_code:old('states_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de estados',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($esCode) ? true : false
										]
									) !!}
								</div>
							</div>
							@endif
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('minutes_code', 'Código de Acta', []) !!}
									{!! Form::text(
										'minutes_code',
										($miCode)?$miCode->format_code:old('minutes_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de las actas',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($miCode) ? true : false
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label(
										'buy-orders_code', 'Código de Orden de Compra', []
									) !!}
									{!! Form::text(
										'buy-orders_code',
										($buCode)?$buCode->format_code:old('buy-orders_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de la orden de compra',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($buCode) ? true : false
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label(
										'service-orders_code', 'Código de Orden de Servicio', []
									) !!}
									{!! Form::text(
										'service-orders_code',
										($soCode)?$soCode->format_code:old('service-orders_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código de la orden de servicio',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($soCode) ? true : false
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('refunds_code', 'Código de Reintegro', []) !!}
									{!! Form::text(
										'refunds_code',
										($reCode)?$reCode->format_code:old('refunds_code'), [
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Formato del código del reintegro',
											'placeholder' => 'Ej. XXX-0000000000-YYYY',
											'readonly' => ($reCode) ? true : false
										]
									) !!}
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
@stop
