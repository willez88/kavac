@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    Pack Iconos
@stop

@section('maproute-title')
    Pack Iconos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Pack Iconos</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#icofont" role="tab">
                                ICOFONT
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#fontawesome" role="tab">
                                FONTAWESOME
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#ionicons" role="tab">
                                IONICONS
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="icofont" role="tabpanel">
							<div class="row">
								@foreach ($icofonts as $icofont)
									<div class="col-md-2 text-center">
										<div class="row">
											<div class="col-12">
												<i class="icofont {{ $icofont }} ico-3x"></i>
											</div>
											<div class="col-12">
												<label>{{ $icofont }}</label>
											</div>
										</div>
									</div>
								@endforeach
							</div>
                        </div>
                        <div class="tab-pane" id="fontawesome" role="tabpanel">
							<div class="row">
								@foreach ($fontawesomes as $fontawesome)
									<div class="col-md-2 text-center">
										<div class="row">
											<div class="col-12">
												<i class="fa {{ $fontawesome }} fa-3x"></i>
											</div>
											<div class="col-12">
												<label>{{ $fontawesome }}</label>
											</div>
										</div>
									</div>
								@endforeach
							</div>
                        </div>
                        <div class="tab-pane" id="ionicons" role="tabpanel">
							<div class="row">
								@foreach ($ionicons as $ionicon)
									<div class="col-md-2 text-center">
										<div class="row">
											<div class="col-12">
												<i class="ion {{ $ionicon }}" style="font-size: 3em;"></i>
											</div>
											<div class="col-12">
												<label>{{ $ionicon }}</label>
											</div>
										</div>
									</div>
								@endforeach
							</div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
@stop