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
	Nacionalidades
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Registrar Nacionalidades</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! (!isset($nationality))?Form::open($header):Form::model($nationality, $header) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">
					    <div class="col-md-6">
					        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
					            {!! Form::label('demonym', 'Gentilicio', []) !!}
					            {!! Form::text('demonym',(isset($nationality))?$nationality->demonym:old('demonym'),
					                [
					                    'class' => 'form-control input-sm',
					                    'data-toggle' => 'tooltip',
					                    'title' => 'Indique el nombre del gentilicio'
					                ]
					            ) !!}
					        </div>
					    </div>
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }} is-required">
								{!! Form::label('country_id', 'País', []) !!}
								{!! Form::select('country_id',(isset($countries))?$countries:[], null,
									[
										'class' => 'form-control select2',
										'data-toggle' => 'tooltip',
										'title' => 'Indique el país'
									]
								) !!}
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
