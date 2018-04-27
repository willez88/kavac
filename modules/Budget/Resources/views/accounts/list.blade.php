@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Catálogo de Cuentas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Catálogo de Cuentas Presupuestarias</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<a href="{{ route('budget.accounts.create') }}" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr class="text-center">
								<th>Código</th>
								<th>Denominación</th>
								<th>Original</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($records as $rec)
								<tr>
									<td width="20%">
										{{ $rec->getCode() }}
									</td>
									<td width="60%">{{ $rec->denomination }}</td>
									<td class="text-center" width="10%">{{ ($rec->original)?'SI':'NO' }}</td>
									<td class="text-center" width="10%">
										{!! Form::button('<i class="fa fa-edit"></i>', [
                                            'class' => 'btn btn-warning btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => 'Editar registro', 
                                            'onclick' => "location='" . route('budget.accounts.edit', $rec->id) . "'"
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o"></i>', [
                                            'class' => 'btn btn-danger btn-xs btn-icon btn-round',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'title' => 'Eliminar registro', 
                                            'onclick' => ''
                                        ]) !!}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop