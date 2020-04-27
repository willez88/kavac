@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	{{ __('Módulos') }}
@stop

@section('maproute-title')
	{{ __('Módulos') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">{{ __('Módulos') }}</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
					</div>
				</div>
				<div class="card-body" style="padding-bottom: 2.25rem">
                    <manage-modules :modules='{!! json_encode($listModules) !!}'></manage-modules>
					<div class="row">
                        {{--
						@foreach ($modules as $module)
							<div class="col-3" style="margin-bottom:30px">
								<div class="info-box">
									<div class="info-box-content info-box-content-lg">
										<div class="info-box-img">
											<i class="{{ $module->icon["name"] ?? "fa fa-cubes" }}"
											   style="color:{{ $module->icon["color"] ?? '#636E7B' }}"></i>
										</div>
										<div class="info-box-title">
											<h6>{{ $module->get('name_es') ?? $module->getName() }}</h6>
										</div>
										<div class="info-box-description">
											<p>{{ $module->getDescription() }}</p>
											@if (count($module->getRequires()) > 0)
												<p class="text-bold">{{ __('Requerimientos') }}:</p>
												<ul>
													@foreach ($module->getRequires() as $key => $version)
														<li>{{ $key }} v{{ $version }}</li>
													@endforeach
												</ul>
											@endif
											@if (!is_null($module->get('authors')) && count($module->get('authors')) > 0)
												<p>{{ __('Autor(es)') }}:</p>
												<ul>
													@foreach ($module->get('authors') as $author)
														<li>
															{{ $author['name'] }}<br/>
															@if (is_array($author['email']))
																@foreach ($author['email'] as $email)
																	{{ $email }}<br/>
																@endforeach
															@else
																{{ $author['email'] }}
															@endif
														</li>
													@endforeach
												</ul>
											@endif
										</div>
										<div class="info-box-footer buttons">
											<div class="row">
												<div class="col-4 text-left">
													<a href="javascript:void(0)" data-module="{!! $module->getName() !!}"
													   class="btn btn-sm btn-round btn-success btn-enable"
													   title="{{ __('Instalar módulo') }}" data-toggle="tooltip">
														<i class="ion ion-android-done"></i>
													</a>
												</div>
												<div class="col-4"></div>
												<div class="col-4 text-right">
													<a href="javascript:void(0)" data-module="{!! $module->getName() !!}"
													   class="btn btn-sm btn-round btn-danger btn-disable"
													   title="{{ __('Desinstalar módulo') }}" data-toggle="tooltip">
														<i class="ion ion-android-close"></i>
													</a>
												</div>
											</div>
											@php
												$moduleStatus = ($module->isEnabled()) ? 'installed' : 'uninstalled';
											@endphp
											<span class="status {!! $moduleStatus !!}">
												{{ ($moduleStatus === "installed") ? __('Instalado') : __('Desinstalado') }}
											</span>
										</div>
									</div>
								</div>
							</div>
						@endforeach
                        --}}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	@parent
    {!! Html::script('js/module-settings.js', [], Request::secure()) !!}
	<script>
		$(document).ready(function() {
			$(".btn-enable").on("click", function() {
				axios.post('{{ route('module.enable') }}', {
					module: $(this).data('module')
				}).then(response => {
					if (response.data.result) {
						$.gritter.add({
                            title: 'Éxito!',
                            text: 'Módulo habilitado satisfactoriamente',
                            class_name: 'growl-success',
                            image: "{{ asset('images/screen-ok.png') }}",
                            sticky: false,
                            time: 2500
                        });

                        setTimeout(function() {
                        	location.href = '{{ route('module.list') }}'
                        }, 2500);
					}
				}).catch(error => {
					logs('setting-modules', 130, error);
				});
			});
			$(".btn-disable").on("click", function() {
				axios.post('{{ route('module.disable') }}', {
					module: $(this).data('module')
				}).then(response => {
					if (response.data.result) {
						$.gritter.add({
                            title: 'Éxito!',
                            text: 'Módulo deshabilitado satisfactoriamente',
                            class_name: 'growl-success',
                            image: "{{ asset('images/screen-ok.png') }}",
                            sticky: false,
                            time: 2500
                        });

                        setTimeout(function() {
                        	location.href = '{{ route('module.list') }}'
                        }, 2500);
					}
				}).catch(error => {
					logs('setting-modules', 152, error);
				});
			});
		});
	</script>
@stop
{{-- <div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Módulos</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Presupuesto</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Finanzas</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Compras</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Almacén</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Contabilidad</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Facturación</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dash-box dash-box-warning">
							<div class="dash-box-icon">
								<i class="fa fa-download"></i>
							</div>
							<div class="dash-box-body">
								<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
								<br>
								<span class="dash-box-title">Cuentas por Cobrar</span>
							</div>
							<div class="dash-box-action">
								<button>Activar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer"></div>
		</div>
	</div>
</div> --}}
