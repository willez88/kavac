@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    {{ __('Componentes de Interfaz') }}
@stop

@section('maproute-title')
    {{ __('Componentes de Interfaz') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Componentes') }}
						@include('buttons.help', [
                            'helpId' => 'developmentComponents',
                            'helpSteps' => get_json_resource('ui-guides/dev_components.json')
                        ])
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => route('index')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body" id="helpComponents">
					<h6>{{ __('Tarjetas informativas') }}</h6>
					<div class="row">
						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-info elevation-1">
									<i class="fa fa-gear"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">CPU Traffic</span>
									<span class="info-box-number">10<small>%</small></span>
									<div class="progress">
										<div class="progress-bar bg-primary" style="width: 70%"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-warning elevation-1">
									<i class="fa fa-gear"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">CPU Traffic</span>
									<span class="info-box-number">10<small>%</small></span>
									<div class="progress">
										<div class="progress-bar bg-primary" style="width: 70%"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-primary elevation-1">
									<i class="fa fa-gear"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">CPU Traffic</span>
									<span class="info-box-number">10<small>%</small></span>
									<div class="progress">
										<div class="progress-bar bg-primary" style="width: 70%"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<span class="info-box-icon bg-success elevation-1">
									<i class="fa fa-gear"></i>
								</span>
								<div class="info-box-content">
									<span class="info-box-text">CPU Traffic</span>
									<span class="info-box-number">10<small>%</small></span>
									<div class="progress">
										<div class="progress-bar bg-primary" style="width: 70%"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- <hr>
					<h6>{{ __('Módulos') }}</h6>
					<div class="row">
						<div class="col-4">
							<div class="info-box">
								<div class="info-box-content info-box-content-lg">
									<div class="info-box-img">
										<i class="fa fa-cubes"></i>
									</div>
									<div class="info-box-title">
										<h6>Título</h6>
									</div>
									<div class="info-box-description">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium facilis dicta ratione ex, officiis, aut ullam culpa recusandae incidunt deserunt, tempora, a numquam velit beatae debitis quia dolores corrupti aliquid!
									</div>
									<div class="info-box-footer buttons">
										<div class="row">
											<div class="col" style="">
												<button class="btn btn-sm btn-info btn-simple btn-round btn-block">Instalar</button>
											</div>
											<div class="col text-center" style="border-left: 1px solid rgba(0, 0, 0, 0.24);padding: 8px 15px;">
												<a href="#">Detalles</a>
											</div>
										</div>
										<!--<div class="row">
											<div class="col-4 text-left">
												<a href="" class="btn btn-sm btn-round btn-success"
												   title="Instalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-done"></i>
												</a>
											</div>
											<div class="col-4"></div>
											<div class="col-4 text-right">
												<a href="" class="btn btn-sm btn-round btn-danger"
												   title="Desinstalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-close"></i>
												</a>
											</div>
										</div>
										<span class="status installed">
											Instalado
										</span>-->
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<div class="info-box-content info-box-content-lg">
									<div class="info-box-img">
										<img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised">
										<i class="fa fa-cubes"></i>
									</div>
									<div class="info-box-title">
										<h6>Título</h6>
									</div>
									<div class="info-box-description">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium facilis dicta ratione ex, officiis, aut ullam culpa recusandae incidunt deserunt, tempora, a numquam velit beatae debitis quia dolores corrupti aliquid!
									</div>
									<div class="info-box-footer buttons">
										<div class="row">
											<div class="col-4 text-left">
												<a href="" class="btn btn-sm btn-round btn-success"
												   title="Instalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-done"></i>
												</a>
											</div>
											<div class="col-4"></div>
											<div class="col-4 text-right">
												<a href="" class="btn btn-sm btn-round btn-danger"
												   title="Desinstalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-close"></i>
												</a>
											</div>
										</div>
										<span class="status uninstalled">
											Desinstalado
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<div class="info-box-content info-box-content-lg">
									<div class="info-box-img">
										<img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised">
										<i class="fa fa-cubes"></i>
									</div>
									<div class="info-box-title">
										<h6>Título</h6>
									</div>
									<div class="info-box-description">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium facilis dicta ratione ex, officiis, aut ullam culpa recusandae incidunt deserunt, tempora, a numquam velit beatae debitis quia dolores corrupti aliquid!
									</div>
									<div class="info-box-footer buttons">
										<div class="row">
											<div class="col-4 text-left">
												<a href="" class="btn btn-sm btn-round btn-success"
												   title="Instalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-done"></i>
												</a>
											</div>
											<div class="col-4"></div>
											<div class="col-4 text-right">
												<a href="" class="btn btn-sm btn-round btn-danger"
												   title="Desinstalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-close"></i>
												</a>
											</div>
										</div>
										<span class="status enabled">
											Activo
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<div class="info-box-content info-box-content-lg">
									<div class="info-box-img">
										<img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised">
										<i class="fa fa-cubes"></i>
									</div>
									<div class="info-box-title">
										<h6>Título</h6>
									</div>
									<div class="info-box-description">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium facilis dicta ratione ex, officiis, aut ullam culpa recusandae incidunt deserunt, tempora, a numquam velit beatae debitis quia dolores corrupti aliquid!
									</div>
									<div class="info-box-footer buttons">
										<div class="row">
											<div class="col-4 text-left">
												<a href="" class="btn btn-sm btn-round btn-success"
												   title="Instalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-done"></i>
												</a>
											</div>
											<div class="col-4"></div>
											<div class="col-4 text-right">
												<a href="" class="btn btn-sm btn-round btn-danger"
												   title="Desinstalar módulo" data-toggle="tooltip">
													<i class="ion ion-android-close"></i>
												</a>
											</div>
										</div>
										<span class="status disabled">
											inactivo
										</span>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
					<hr>
                    <h6>{{ __('Cintas') }}</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-blue float-left"><i class="mdi mdi-access-point mr-1"></i> Blue</div>
                                <h6 class="text-blue float-right mt-0">Blue Header</h6>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores magnam voluptates adipisci molestiae blanditiis a ad, ipsum. Excepturi dolorem laboriosam, quae, placeat at veritatis porro quibusdam incidunt nostrum, ab facilis.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-primary float-right"><i class="mdi mdi-access-point mr-1"></i> Primary</div>
                                <h5 class="text-primary float-left mt-0">Primary Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-success float-right"><i class="mdi mdi-access-point mr-1"></i> Success</div>
                                <h5 class="text-success float-left mt-0">Success Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-info float-left"><i class="mdi mdi-access-point mr-1"></i> Info</div>
                                <h5 class="text-info float-right mt-0">Info Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-warning float-right"><i class="mdi mdi-access-point mr-1"></i> Warning</div>
                                <h5 class="text-warning float-left mt-0">Warning Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-danger float-right"><i class="mdi mdi-access-point mr-1"></i> Danger</div>
                                <h5 class="text-danger float-left mt-0">Danger Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-pink float-left"><i class="mdi mdi-access-point mr-1"></i> Pink</div>
                                <h5 class="text-pink float-right mt-0">Pink Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-secondary float-right"><i class="mdi mdi-access-point mr-1"></i> Secondary</div>
                                <h5 class="text-secondary float-left mt-0">Secondary Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-dark float-right"><i class="mdi mdi-access-point mr-1"></i> Dark</div>
                                <h5 class="text-dark float-left mt-0">Dark Header</h5>
                                <div class="ribbon-content">
                                    <p class="mb-0">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-secondary"><span>Secondary</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-primary"><span>Primary</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-success"><span>Success</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-info"><span>Info</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-warning"><span>Warning</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-danger"><span>Danger</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-pink"><span>Pink</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-blue"><span>Blue</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-box ribbon-box">
                                <div class="ribbon-two ribbon-two-dark"><span>Dark</span></div>
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis, dignissimos assumenda, nobis enim molestiae architecto, reprehenderit vel voluptas sed suscipit omnis soluta necessitatibus non perspiciatis quibusdam ipsum deleniti aut repudiandae.
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
					<h6>{{ __('Listas') }}</h6>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<b>{{ __('Listas de funcionalidades') }} / {{ __('tareas') }}</b>
							</div>
							@foreach (['warning', 'default', 'primary', 'success', 'info', 'danger'] as $listType)
								<ul class="feature-list list-group list-group-flush">
						            <li class="list-group-item">
						                <div class="feature-list-indicator bg-{{ $listType }}"></div>
						                <div class="feature-list-content p-0">
						                    <div class="feature-list-content-wrapper">
						                        <div class="feature-list-content-left mr-2">
						                            <div class="custom-checkbox custom-control">
						                                <input type="checkbox" id="elementId" class="custom-control-input">
						                                <label class="custom-control-label" for="elementId">&nbsp;</label>
						                            </div>
						                        </div>
						                        <div class="feature-list-content-left">
						                            <div class="feature-list-heading">
						                                Título
						                                <div class="badge badge-danger ml-2" data-toggle="tooltip"
                                                             title="{{ __('mensaje tooltip a mostrar') }}">
						                                	estatus / acción
						                                </div>
						                            </div>
						                            <div class="feature-list-subheading"><i>Descripción</i></div>
						                        </div>
						                        <div class="feature-list-content-right feature-list-content-actions">
						                        	<button class="btn btn-simple btn-primary btn-events"
						                        			title="{{ __('mensaje tooltip a mostrar') }}"
                                                            data-toggle="tooltip">
						                        		<i class="fa fa-cloud-upload fa-2x"></i>
						                        	</button>
						                        	<button class="btn btn-simple btn-primary btn-events"
						                        			title="{{ __('mensaje tooltip a mostrar') }}"
                                                            data-toggle="tooltip">
						                        		<i class="fa fa-cloud-download fa-2x"></i>
						                        	</button>
						                        </div>
						                    </div>
						                </div>
						            </li>
						        </ul>
							@endforeach
						</div>
					</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">{{ __('Paleta de colores') }}</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
                        @php
                            $colors = [
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(96, 92, 168)',
                                        'text' => '#605ca8'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(85, 82, 153)',
                                        'text' => '#525299'
                                    ]
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(240, 18, 190)',
                                        'text' => '#f012be'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(219, 14, 173)',
                                        'text' => '#db0ead'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(216, 27, 96)',
                                        'text' => '#d81b60'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(202, 25, 90)',
                                        'text' => '#ca195a'
                                    ],
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(255, 133, 27)',
                                        'text' => '#ff851b'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(255, 119, 1)',
                                        'text' => '#ff7701'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(255, 178, 54)',
                                        'text' => '#ffb236'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(243, 156, 18)',
                                        'text' => '#f39c12'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(219, 139, 11)',
                                        'text' => '#db8b0b'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(204, 128, 14)',
                                        'text' => '#cc800e'
                                    ],
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(255, 54, 54)',
                                        'text' => '#ff3636'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(255, 41, 41)',
                                        'text' => '#ff2929'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(249, 99, 50)',
                                        'text' => '#f96332'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(249, 74, 20)',
                                        'text' => '#f94a14'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(239, 94, 48)',
                                        'text' => '#ef5e30'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(221, 75, 57)',
                                        'text' => '#dd4b39'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(211, 55, 36)',
                                        'text' => '#d33724'
                                    ],
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(61, 153, 112)',
                                        'text' => '#3d9970'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(54, 135, 99)',
                                        'text' => '#368763'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(24, 206, 15)',
                                        'text' => '#18ce0f'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(18, 161, 11)',
                                        'text' => '#12a10b'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(1, 255, 112)',
                                        'text' => '#01ff70'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 231, 101)',
                                        'text' => '#00e765'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 166, 90)',
                                        'text' => '#00a65a'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 141, 76)',
                                        'text' => '#008d4c'
                                    ],
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(60, 141, 188)',
                                        'text' => '#3c8dbc'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(57, 204, 204)',
                                        'text' => '#39cccc'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(53, 124, 165)',
                                        'text' => '#357ca5'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(48, 187, 187)',
                                        'text' => '#30bbbb'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(44, 168, 255)',
                                        'text' => '#2ca8ff'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(43, 163, 247)',
                                        'text' => '#2ba3f7'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(32, 126, 189)',
                                        'text' => '#207ebd'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 192, 239)',
                                        'text' => '#00c0ef'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 167, 208)',
                                        'text' => '#00a7d0'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 115, 183)',
                                        'text' => '#0073b7'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 83, 132)',
                                        'text' => '#005384'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 62, 133)',
                                        'text' => '#003e85'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 31, 63)',
                                        'text' => '#001f3f'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 26, 53)',
                                        'text' => '#001a35'
                                    ],
                                ],
                                [
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(255, 255, 255)',
                                        'text' => '#ffffff'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(247, 247, 247)',
                                        'text' => '#f7f7f7'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(247, 236, 236)',
                                        'text' => '#f7ecec'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(238, 238, 238)',
                                        'text' => '#eeeeee'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(235, 236, 241)',
                                        'text' => '#ebecf1'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(228, 231, 234)',
                                        'text' => '#e4e7ea'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(227, 227, 227)',
                                        'text' => '#e3e3e3'
                                    ],
                                    [
                                        'text-color' => 'rgb(154, 154, 154)', 'bg-color' => 'rgb(210, 214, 222)',
                                        'text' => '#d2d6de'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(181, 187, 200)',
                                        'text' => '#b5bbc8'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(154, 154, 154)',
                                        'text' => '#9a9a9a'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(153, 153, 153)',
                                        'text' => '#999999'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(102, 102, 102)',
                                        'text' => '#666666'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(99, 110, 123)',
                                        'text' => '#636e7b'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(85, 85, 85)',
                                        'text' => '#555555'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(51, 51, 51)',
                                        'text' => '#333333'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(34, 34, 34)',
                                        'text' => '#222222'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(17, 17, 17)',
                                        'text' => '#111111'
                                    ],
                                    [
                                        'text-color' => 'rgb(255, 255, 255)', 'bg-color' => 'rgb(0, 0, 0)',
                                        'text' => '#000000'
                                    ],
                                ],
                            ];
                        @endphp

                        @foreach ($colors as $color)
                            <div class="col-sm-4 col-md-2">
                                @foreach ($color as $col)
                                    @php
                                        $background = 'background-color:' . $col['bg-color'];
                                        $textColor = 'color:' . $col['text-color'];
                                        $text = $col['text'] ?? $col['bg-color'];
                                        $style = $background . ';' . $textColor . ';';
                                    @endphp
                                    <div class="color-palette" style="{!! $style !!};">
                                        <span>{!! $text !!}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
						{{-- <div class="col-sm-4 col-md-2">
							<div class="color-palette-set" style="color:#ffffff">
			                  <div class="bg-red color-palette"><span>#dd4b39</span></div>
			                  <div class="bg-primary color-palette"><span>#f96332</span></div>
			                </div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
