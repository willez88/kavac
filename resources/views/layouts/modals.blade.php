@auth
    @php
        $prf = auth()->user()->profile;
        $img_profile = ($prf && $prf->image_id) ? $prf->image->url : null;
    @endphp
    <div class="modal modal-lockscreen fade" id="modal-lockscreen" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body lockscreen">
                    <div class="lockscreen-wrapper">
                        <div class="lockscreen-logo">
                            <img src="{{ asset('images/app-logo-white.png') }}" alt="Logo KAVAC" />
                        </div>
                        <div class="lockscreen-name text-white">@if (Auth::check()) {{ Auth::user()->name }} @endif</div>

                        <div class="lockscreen-item">
                            <div class="lockscreen-image">
                                @php
                                    $avatar = file_exists(base_path($img_profile)) 
                                              ? $img_profile : 'images/default-avatar.png';
                                @endphp
                                <img src="{{ asset($avatar, Request::secure()) }}"
                                     alt="perfil">
                            </div>

                            {!! Form::open(['class' => 'lockscreen-credentials', 'id' => 'form-lockscreen']) !!}
                                <div class="input-group">
                                    {!! Form::password('password', array(
                                        'class' => 'form-control', 'placeholder' => 'contraseña de acceso',
                                        'id' => 'password', 'autocomplete' => 'off'
                                    )) !!}
                                    {!! Form::hidden('username', Auth::check() ? auth()->user()->username : '', [
                                        'id' => 'username'
                                    ]) !!}
                                    <div class="input-group-btn">
                                        <button class="btn" type="button" id="unlock_session" onclick="unlockScreen()">
                                            <i class="fa fa-arrow-right text-muted"></i>
                                        </button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="help-block text-center text-white">
                            {{ __('Ingrese su contraseña para desbloquear la pantalla') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endauth
