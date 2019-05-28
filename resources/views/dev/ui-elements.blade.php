@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    UI Elements
@stop

@section('maproute-title')
    UI Elements
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Componentes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => route('index')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<h6>Tarjetas informativas</h6>
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
					<hr>
					<h6>Módulos</h6>
					<div class="row">
						<div class="col-3">
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
										</span>										
									</div>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="info-box">
								<div class="info-box-content info-box-content-lg">
									<div class="info-box-img">
										{{-- <img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised"> --}}
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
										{{-- <img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised"> --}}
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
										{{-- <img src="{{ asset('images/no-image.png') }}" alt="Thumbnail Image" class="rounded img-raised"> --}}
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
					<h6 class="card-title">Paleta de colores</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-4 col-md-2">
							<div class="color-palette-set" style="color:#ffffff">
			                  <div class="bg-red color-palette"><span>#dd4b39</span></div>
			                  <div class="bg-primary color-palette"><span>#f96332</span></div>
			                </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop