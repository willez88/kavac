@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="{{ asset('images/default-avatar.png') }}" alt="" 
                                 style="border:1px solid #519BF6; padding:15px; border-radius: 20px;">
                        </div>
                        <div class="col-12 text-center">
                            <h4>Nombre</h4>
                            <h5>Cargo</h5>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info btn-block">Bloquear Pantalla</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#activity" role="tab">
                            <i class="now-ui-icons objects_umbrella-13"></i> Actividad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            <i class="now-ui-icons shopping_cart-simple"></i> Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                            <i class="now-ui-icons shopping_shop"></i> Mensajes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#directory" role="tab">
                            <i class="now-ui-icons ui-2_settings-90"></i> Directorio
                        </a>
                    </li>
                </ul>
                <div class="card-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="activity" role="tabpanel">
                            <p>I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. So when you get something that has the name Kanye West on it, it’s supposed to be pushing the furthest possibilities. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus.</p>
                        </div>
                        <div class="tab-pane" id="profile" role="tabpanel">
                            {!! Form::model($model, $header) !!}
                                <div class="form-group">
                                    <label class="control-label" for="name">Nombre</label>
                                    <input class="form-control" id="name" readonly="readonly" placeholder="indique el nombre" name="name" value="" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email">Correo Electrónico</label>
                                    <input class="form-control" id="email" readonly="readonly" placeholder="forms.email_placeholder" name="email" value="" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="username">Usuario</label>
                                    <input class="form-control" id="username" readonly="readonly" placeholder="Nombre de usuario" name="username" value="" type="text">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password">Nueva Contraseña</label>
                                    <input class="form-control" id="password" placeholder="indique la nueva contraseña" name="password" value="" type="password">
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <div class="progress">
                                            <div id="complexity-bar" class="progress-bar progress-bar-danger" role="progressbar" style="width: 0%;"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <p id="complexity" class="pull-right font-bold">0%</p>
                                        <input id="complexity-level" name="complexity-level" type="hidden">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password_confirmation">
                                        Confirmar Contraseña
                                    </label>
                                    <input class="form-control" id="password_confirmation" placeholder="indique nuevamente la contraseña" name="password_confirmation" value="" type="password">
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 text-right">
                                        {!! Form::button('<i class="fa fa-save"></i>', [
                                            'class' => 'btn btn-success btn-icon btn-round', 'type' => 'submit',
                                            'data-toggle' => 'tooltip', 'title' => 'Guardar registro', 
                                        ]) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="tab-pane" id="messages" role="tabpanel">
                            <p>I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at. So when you get something that has the name Kanye West on it, it’s supposed to be pushing the furthest possibilities. I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus.</p>
                        </div>
                        <div class="tab-pane" id="directory" role="tabpanel">
                            <p>
                                "I will be the leader of a company that ends up being worth billions of dollars, because I got the answers. I understand culture. I am the nucleus. I think that’s a responsibility that I have, to push possibilities, to show people, this is the level that things could be at."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop