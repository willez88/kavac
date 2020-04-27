@extends('layouts.app')

@section('content')
    {!! Form::open(['url' => '/login', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <div class="header header-primary text-center">
            <div class="logo-container">
                @include('layouts.logo-images', ['logo_mini' => true])
            </div>
            <h6>{{ __('Acceso') }}</h6>
        </div>
        <div class="content">
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons users_circle-08"></i>
                    </span>
                    {!! Form::text('username', old('username'), [
                        'class' => 'form-control', 'placeholder' => __('Usuario'), 'required' => 'required',
                        'title' => __('Indique el nombre del usuario.'),
                        'data-toggle' => 'tooltip', 'data-placement' => 'right'
                    ]) !!}
                </div>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons ui-1_lock-circle-open"></i>
                    </span>
                    {!! Form::password('password', [
                        'class' => 'form-control', 'placeholder' => __('Contraseña'), 'required' => 'required',
                        'title' => __('Indique la contraseña de acceso.'),
                        'data-toggle' => 'tooltip', 'data-placement' => 'right'
                    ]) !!}
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 text-right">
                        <div class="captcha-addon">{!! Captcha::img(); !!}</div>
                    </div>
                    <div class="col-md-3 text-left">
                        <i class="now-ui-icons arrows-1_refresh-69 cursor-pointer captcha-reload vertical-middle"
                           onclick="refresh_captcha()" data-toggle="tooltip"
                           title="{{ __('Presione este botón para generar una nueva imagen de captcha') }}"></i>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons design_image"></i>
                    </span>
                    {!! Form::text('captcha', old('captcha'), [
                        'class' => 'form-control', 'placeholder' => __('Captcha'), 'required' => 'required',
                        'id' => 'captcha', 'onfocus' => '$(this).val("")', 'data-toggle' => 'tooltip',
                        'title' => __('Introduzca los carácteres de la imagen'), 'data-placement' => 'right'
                    ]) !!}
                </div>
                @if ($errors->has('captcha'))
                    <span class="help-block">
                        <strong>{{ $errors->first('captcha') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="footer text-center">
            <label>
                <span style="margin-right:10px">{{ __('Recuerdame') }}</span>
                <input type="checkbox" name="checkbox" class="form-control bootstrap-switch"
                       data-on-label="SI" data-off-label="NO" data-toggle="tooltip" data-placement="right"
                       title="{{ __('Seleccione si desea que el sistema recuerde sus datos') }}" />
            </label>

            <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip" data-placement="right"
                    title="{{ __('Presione el botón para validar los datos y acceder al sistema') }}">
                {{ __('Acceso') }}
            </button>
            <a class="btn btn-link" href="{{ route('password.request') }}" data-toggle="tooltip" data-placement="right"
               title="{{ __('¿Olvido su contraseña?, presione sobre el enlace para modificarla') }}">
                {{ __('¿Olvidaste la contraseña?') }}
            </a>
        </div>
    </form>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            $('.bootstrap-switch-wrapper').attr({
                'title': '{{ __('Seleccione si desea que el sistema recuerde sus datos') }}',
                'data-toggle': 'tooltip'
            }).tooltip({
                trigger:"hover",
                delay: {hide: 200}
            });
        });
        /**
         * Función que permite cargar una nueva imagen de captcha
         */
        function refresh_captcha() {
            $.ajax({
                url: '{{ url('/refresh-captcha') }}',
                type: 'get',
                dataType: 'html',
                success: function(data) {
                    $('.captcha-addon').html(data);
                    $('#captcha').val('');
                }
            }).fail(function(jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                bootbox.alert( err );
            });
        }
    </script>
@endsection
