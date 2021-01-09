@extends('layouts.app')

@section('content')
    {!! Form::open(['url' => '/login', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <p class="login-img">
            @include('layouts.logo-images', ['logo_mini' => true])
        </p>
        <h2 class="h6 text-light text-center pb-3">{{ __('Acceso') }}</h2>
        <div class="mb-2 pb-1 form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon">
                    <i class="now-ui-icons users_circle-08"></i>
                </span>
                {!! Form::text('username', old('username'), [
                    'class' => 'form-control', 'placeholder' => __('Usuario'),
                    'title' => __('Indique el nombre del usuario.'),
                    'data-toggle' => 'tooltip', 'data-placement' => 'top'
                ]) !!}
            </div>
            @if ($errors->has('username'))
                <p class="text-center text-light mb-0">
                    <strong>{{ $errors->first('username') }}</strong>
                </p>
            @endif
        </div>
        <div class="mb-2 pb-1 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon">
                    <i class="now-ui-icons ui-1_lock-circle-open"></i>
                </span>
                {!! Form::password('password', [
                    'class' => 'form-control', 'placeholder' => __('Contraseña'),
                    'title' => __('Indique la contraseña de acceso.'),
                    'data-toggle' => 'tooltip', 'data-placement' => 'top',
                    'autocomplete' => 'off'
                ]) !!}
            </div>
            @if ($errors->has('password'))
                <p class="text-center text-light mb-0">
                    <strong>{{ $errors->first('password') }}</strong>
                </p>
            @endif
        </div>
        <div class="form-group">
            <div class="login-captcha-grid">
                <div class="captcha-addon text-right">{!! Captcha::img(); !!}</div>
                <div class="text-left text-light mb-0">
                    <i class="now-ui-icons arrows-1_refresh-69 cursor-pointer captcha-reload vertical-middle my-0 pt-1"
                       onclick="refresh_captcha()" data-toggle="tooltip"
                       title="{{ __('Presione este botón para generar una nueva imagen de captcha') }}"></i>
                </div>
            </div>
        </div>
        <div class="mb-2 form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
            <div class="input-group form-group-no-border input-sm">
                <span class="input-group-addon">
                    <i class="now-ui-icons design_image"></i>
                </span>
                {!! Form::text('captcha', old('captcha'), [
                    'class' => 'form-control', 'placeholder' => __('Captcha'),
                    'id' => 'captcha', 'onfocus' => '$(this).val("")', 'data-toggle' => 'tooltip',
                    'title' => __('Introduzca los carácteres de la imagen'), 'data-placement' => 'top'
                ]) !!}
            </div>
            @if ($errors->has('captcha'))
                <p class="text-center text-light mb-0">
                    <strong>{{ $errors->first('captcha') }}</strong>
                </p>
            @endif
        </div>
        <div class="footer text-center">
            <label class="mb-0">
                <span class="btn btn-link font-small">{{ __('Recuérdame') }}</span>
                <input type="checkbox" name="remember" class="form-control bootstrap-switch mb-0"
                       data-on-label="SI" data-off-label="NO" data-toggle="tooltip" data-placement="top"
                       title="{{ __('Seleccione si desea que el sistema recuerde sus datos') }}" />
            </label>

            <button class="btn btn-primary btn-round btn-block" data-toggle="tooltip" data-placement="top"
                    title="{{ __('Presione el botón para validar los datos y acceder al sistema') }}">
                {{ __('Acceso') }}
            </button>
            <a class="btn btn-link" href="{{ route('password.request') }}" data-toggle="tooltip" data-placement="top"
               title="{{ __('Presione el enlace para recuperar su contraseña') }}">
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
