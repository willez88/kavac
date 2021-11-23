@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    {{ __('Paquetes de Iconos') }}
@stop

@section('maproute-title')
    {{ __('Paquetes de Iconos') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
                        {{ __('Paquetes de Iconos') }}
                        @include('buttons.help', [
                            'helpId' => 'developmentIcons',
                            'helpSteps' => get_json_resource('ui-guides/pack_icons.json')
                        ])
                    </h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist" id="helpIconTabs">
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
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#nucleo" role="tab">
                                NUCLEO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#material" role="tab">
                                MATERIAL DESIGN
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="helpPackContent">
                        <div class="tab-pane active" id="icofont" role="tabpanel">
							<div class="row">
								@foreach ($icofonts as $key => $icofont)
                                    @php
                                        $icofontIdx = $loop->index;
                                    @endphp
									<div class="col-sm-12">
										<hr>
										<h6 class="card-title">
                                            {{ $key }}
                                            <a class="btn btn-collapse" data-toggle="collapse"
                                               href="#icofontContent{{ $icofontIdx }}"
                                               aria-expanded="true" aria-controls="icofontContent{{ $icofontIdx }}"
                                               style="padding:4px;font-size:0.7em;background-color: transparent;color:#0073b7" title="{{ __('Mostrar / Ocultar contenido') }}">
                                                <i class="now-ui-icons arrows-1_minimal-up"></i>
                                            </a>
                                        </h6>
									</div>
                                    <div class="col-sm-12 collapse show" id="icofontContent{{ $icofontIdx }}">
                                        <div class="row">
                                            @foreach ($icofont as $icon)
        										<div class="col-md-2 text-center">
        											<div class="row">
        												<div class="col-12">
        													<i class="icofont {{ $icon }} ico-2x"></i>
        												</div>
        												<div class="col-12">
        													<label>icofont {{ $icon }}</label>
        												</div>
        											</div>
        										</div>
        									@endforeach
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
												<i class="fa {{ $fontawesome }} fa-2x"></i>
											</div>
											<div class="col-12">
												<label>fa {{ $fontawesome }}</label>
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
												<i class="ion {{ $ionicon }}" style="font-size: 2em;"></i>
											</div>
											<div class="col-12">
												<label>ion {{ $ionicon }}</label>
											</div>
										</div>
									</div>
								@endforeach
							</div>
                        </div>
                        <div class="tab-pane" id="nucleo" role="tabpanel">
                            <div class="row">
                                @foreach ($nucleos as $key => $nucleo)
                                    @php
                                        $nucleoIdx = $loop->index;
                                    @endphp
                                    <div class="col-12">
                                        <hr>
                                        <h6 class="card-title">
                                            {{ $key }}
                                            <a class="btn btn-collapse" data-toggle="collapse"
                                               href="#nucleoContent{{ $nucleoIdx }}"
                                               aria-expanded="true" aria-controls="nucleoContent{{ $nucleoIdx }}"
                                               style="padding:4px;font-size:0.7em;background-color: transparent;color:#0073b7" title="{{ __('Mostrar / Ocultar contenido') }}">
                                                <i class="now-ui-icons arrows-1_minimal-up"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="col-sm-12 collapse show" id="nucleoContent{{ $nucleoIdx }}">
                                        <div class="row">
                                            @foreach ($nucleo as $nuc)
                                                <div class="col-md-2 text-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <i class="now-ui-icons {{ $nuc }}"
                                                               style="font-size: 2em;"></i>
                                                        </div>
                                                        <div class="col-12">
                                                            <label>now-ui-icons {{ $nuc }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane" id="material" role="tabpanel">
                            <div class="row">
                                @foreach ($materialDesigns as $key => $material)
                                    @php
                                        $materialIdx = $loop->index;
                                    @endphp
                                    <div class="col-12">
                                        <hr>
                                        <h6 class="card-title">
                                            {{ $key }}
                                            <a class="btn btn-collapse" data-toggle="collapse"
                                               href="#materialContent{{ $materialIdx }}"
                                               aria-expanded="true" aria-controls="materialContent{{ $materialIdx }}"
                                               style="padding:4px;font-size:0.7em;background-color: transparent;color:#0073b7" title="{{ __('Mostrar / Ocultar contenido') }}">
                                                <i class="now-ui-icons arrows-1_minimal-up"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="col-sm-12 collapse show" id="materialContent{{ $materialIdx }}">
                                        <div class="row">
                                            @foreach ($material as $mat)
                                                <div class="col-md-2 text-center">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <i class="mdi {{ $mat }}"
                                                               style="font-size: 2em;"></i>
                                                        </div>
                                                        <div class="col-12">
                                                            <label>mdi {{ $mat }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
