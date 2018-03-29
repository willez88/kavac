@extends('layouts.app')

@section('content')
    {!! Form::open(['url' => '/login', 'method' => 'POST', 'class' => 'form']) !!}
        {{ csrf_field() }}
        <div class="header header-primary text-center">
            <div class="logo-container">
                <img src="{{ asset('images/logo-mini.png') }}" alt="">
            </div>
        </div>
        <div class="content">
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons users_circle-08"></i>
                    </span>
                    {!! Form::text('username', old('username'), [
                        'class' => 'form-control', 'placeholder' => 'Usuario', 'required' => 'required'
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
                    {!! Form::text('password', old('password'), [
                        'class' => 'form-control', 'placeholder' => 'Contraseña', 'required' => 'required'
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
                    <div class="col-md-8 text-right">
                        <div class="captcha-addon">{!! Captcha::img(); !!}</div>
                    </div>
                    <div class="col-md-4 text-left">
                        <i class="now-ui-icons arrows-1_refresh-69 cursor-pointer vertical-middle" 
                           onclick="refresh_captcha()"></i>
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                <div class="input-group form-group-no-border input-sm">
                    <span class="input-group-addon">
                        <i class="now-ui-icons design_image"></i>
                    </span>
                    {!! Form::text('captcha', old('captcha'), [
                        'class' => 'form-control', 'placeholder' => 'Captcha', 'required' => 'required',
                        'id' => 'captcha'
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
                <span style="margin-right:10px">Recuerdame</span>
                <input type="checkbox" name="checkbox" class="form-control bootstrap-switch" data-on-label="SI" data-off-label="NO" />
            </label>
            
            <button class="btn btn-primary btn-round btn-lg btn-block">Acceso</button>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                ¿Olvidaste la contraseña?
            </a>
        </div>
        <!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>-->
    </form>
@endsection

@section('extra-js')
    <script>
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