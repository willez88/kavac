@extends('digitalsignature::layouts.master')

@section('content')
    <p>
        This view is loaded from module: {!! config('digitalsignature.name') !!}
    </p>

    <div class="card-body">
        
        @php
            $user = Auth::User();
        @endphp

        <div>
            <div class="row">
                <div>
                    <h3 class="h4 border-bottom border-primary text-center pb-1">
                        Datos personales
                    </h3>
                    <p>
                        <span class="font-weight-bold"> Usuario: </span>
                        <span class="text-gray-900"> {{ $user->name }} </span>
                    </p>
                    <p>
                        <span class="font-weight-bold"> Correo: </span>
                        <span class="text-gray-900"> {{ $user->email }} </span>
                    </p>
                    <p>
                        <span class="font-weight-bold"> Certificado: </span>
                        <br> 
                        	@if($cert == 'true')
								<span class="text-gray-900"> Identidad: {{ $Identidad }}</span><br>
	                        	<span class="text-gray-900"> Validado por: {{ $Verificado }}</span><br>
	                        	<span class="text-gray-900"> Caduca: {{ $Caduca }}</span><br>
	                        @else
								<span class="text-gray-900"> No posee certificado firmante</span>
							@endif
                        <a class="dropdown-item" href="{{ route('fileprofile') }}">
                            {{ __('Cargar certificado') }}
                        </a>
                        <span class="text-gray-900"> </span>
                    </p>
                    <p>
                        @if($cert == 'true')
                            <a class="dropdown-item" href="{{ route('certificateDetails') }}">
                                {{ __('Detalles del certificado') }}

                                <p> {{ greet('Brian') }} </p>
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
