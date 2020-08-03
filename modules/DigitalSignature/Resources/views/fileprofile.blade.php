@extends('digitalsignature::layouts.master')

@section('content')
    <p>
        This view is loaded from module: {!! config('digitalsignature.name') !!}
    </p>
    <div class="card-body">
        <div>
            <div class="row">
                <div>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('signprofilestore') }}" accept-charset="UTF-8" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            <label>Cargar Certificado firmante</label>
                            <div>
                                <input type="file" class="form-control" name="pkcs12">
                            </div>
                            <input id="phasepass" class="form-control" type="password" name="password"
                   required tabindex="3" placeholder="pkcs12 password" />
                        </div>
                        <div>
                            <div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@stop
