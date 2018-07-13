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
	Tipo de Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Tipos de Personal</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{{-- {!! Form::open($header) !!} --}}
					<div class="card-body">
						<table class="table table-hover table-striped dt-responsive">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Descripción</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{{-- {!! Form::close() !!} --}}
			</div>
		</div>
	</div>
@stop
