@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    Formularios
@stop

@section('maproute-title')
    Formularios
@stop

@section('extra-css')
    @parent
    <style>
        .typography-line {
            padding-left: 25%;
            margin-bottom: 35px;
            position: relative;
            display: block;
            width: 100%;
        }
        .typography-line span {
            bottom: 10px;
            color: #c0c1c2;
            display: block;
            font-weight: 400;
            font-size: 13px;
            line-height: 13px;
            left: 0;
            margin-left: 20px;
            position: absolute;
            width: 260px;
            text-transform: none;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Elementos de formularios</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="pad-top-10">Inputs</h6>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <input type="text" value="" placeholder="Regular" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group has-success">
                                <input type="text" value="Success" class="form-control form-control-success input-sm">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group has-danger">
                                <input type="email" value="Error" class="form-control form-control-danger input-sm">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <div class="input-group input-sm">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Left Font Awesome Icon">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <div class="input-group input-sm">
                                    <input type="text" class="form-control" placeholder="Right Nucleo Icon">
                                    <span class="input-group-addon">
                                        <i class="now-ui-icons users_single-02"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="pad-top-10">Acciones</h6>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <p class="category">Checkboxes</p>
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1">
                                    No seleccionado
                                </label>
                            </div>
                            <div class="checkbox">
                                <input id="checkbox2" type="checkbox" checked="">
                                <label for="checkbox2">
                                    Seleccionado
                                </label>
                            </div>
                            <div class="checkbox">
                                <input id="checkbox3" type="checkbox" disabled="">
                                <label for="checkbox3">
                                    Deshabilitado no seleccionado
                                </label>
                            </div>
                            <div class="checkbox">
                                <input id="checkbox4" type="checkbox" checked="" disabled="">
                                <label for="checkbox4">
                                    Deshabilitado seleccionado
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <p class="category">Radios</p>
                            <div class="radio">
                                <input type="radio" name="radio1" id="radio1" value="option1">
                                <label for="radio1">
                                    Radio esta descativado
                                </label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="radio1" id="radio2" value="option2" checked="">
                                <label for="radio2">
                                    Radio esta activado
                                </label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="radio3" id="radio3" value="option3" disabled="">
                                <label for="radio3">
                                    Radio esta desactivado y deshabilitado
                                </label>
                            </div>
                            <div class="radio">
                                <input type="radio" name="radio4" id="radio4" value="option4" checked="" disabled="">
                                <label for="radio4">
                                    Radio esta activado y deshabilitado
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <p class="category">Botones de selección</p>
                            <input type="checkbox" name="checkbox" class="bootstrap-switch" checked="">
                            <br>
                            <input type="checkbox" name="checkbox" class="bootstrap-switch" data-on-label="ON" data-off-label="OFF">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <p class="category">Sliders</p>
                            <div id="sliderRegular" class="slider"></div>
                            <br>
                            <div id="sliderDouble" class="slider slider-primary"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Barras de progreso</h4>
                            <div class="progress-container">
                                <span class="progress-badge">Default</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        <span class="progress-value">25%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-container progress-primary">
                                <span class="progress-badge">Primary</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        <span class="progress-value">60%</span>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <h4>Navegación Pills</h4>
                            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#active" role="tablist">
                                        <i class="fa fa-diamond"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#link" role="tablist">
                                        <i class="fa fa-thermometer-full"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#link" role="tablist">
                                        <i class="fa fa-suitcase"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link disabled" data-toggle="tab" href="#disabled" role="tablist">
                                        <i class="fa fa-exclamation"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4>Paginación</h4>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-primary">
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">5</a>
                                    </li>
                                </ul>
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#link" aria-label="Previous">
                                            <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">1</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#link" aria-label="Next">
                                            <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <br>
                            <h4>Etiquetas</h4>
                            <span class="badge badge-default">Default</span>
                            <span class="badge badge-primary">Primary</span>
                            <span class="badge badge-success">Success</span>
                            <span class="badge badge-info">Info</span>
                            <span class="badge badge-warning">Warning</span>
                            <span class="badge badge-danger">Danger</span>
                        </div>
                    </div>
                    <h6 class="pad-top-10">Notificaciones</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-2_like"></i>
                                    </div>
                                    <strong>Well done!</strong> You successfully read this important alert message.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="now-ui-icons ui-1_simple-remove"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons travel_info"></i>
                                    </div>
                                    <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="now-ui-icons ui-1_simple-remove"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons ui-1_bell-53"></i>
                                    </div>
                                    <strong>Warning!</strong> Better check yourself, you're not looking too good.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="now-ui-icons ui-1_simple-remove"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <div class="container">
                                    <div class="alert-icon">
                                        <i class="now-ui-icons objects_support-17"></i>
                                    </div>
                                    <strong>Oh snap!</strong> Change a few things up and try submitting again.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="now-ui-icons ui-1_simple-remove"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6 class="pad-top-10">Tipografía</h6>
                    <div id="typography">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="typography-line">
                                    <h1>
                                        <span>Encabezado 1</span>Lorem ipsum dolor sit amet</h1>
                                </div>
                                <div class="typography-line">
                                    <h2>
                                        <span>Encabezado 2</span>Lorem ipsum dolor sit amet</h2>
                                </div>
                                <div class="typography-line">
                                    <h3>
                                        <span>Encabezado 3</span>Lorem ipsum dolor sit amet</h3>
                                </div>
                                <div class="typography-line">
                                    <h4>
                                        <span>Encabezado 4</span>Lorem ipsum dolor sit amet</h4>
                                </div>
                                <div class="typography-line">
                                    <h5>
                                        <span>Encabezado 5</span>Lorem ipsum dolor sit amet</h5>
                                </div>
                                <div class="typography-line">
                                    <h6>
                                        <span>Encabezado 6</span>Lorem ipsum dolor sit amet</h6>
                                </div>
                                <div class="typography-line">
                                    <p>
                                        <span>Párrafo</span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae, vero odit. Facere saepe ipsa dolores, id. Quas vitae perferendis in placeat natus quia quaerat, non, dicta, autem obcaecati quis, eaque?
                                    </p>
                                </div>
                                <div class="typography-line">
                                    <span>Cita</span>
                                    <blockquote>
                                        <p class="blockquote blockquote-primary">
                                            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda, molestiae ratione voluptatum doloribus, eaque animi neque ipsam deserunt nemo labore veniam enim cumque velit id similique asperiores repudiandae sint."
                                            <br>
                                            <br>
                                            <small>
                                                - autor
                                            </small>
                                        </p>
                                    </blockquote>
                                </div>
                                <div class="typography-line">
                                    <span>Texto apagado</span>
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint beatae illum odit laudantium voluptatum quasi laborum eum, incidunt nulla culpa maiores libero animi doloribus nostrum molestias tenetur quaerat unde illo....
                                    </p>
                                </div>
                                <div class="typography-line">
                                    <span>Primary Text</span>
                                    <p class="text-primary">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut perspiciatis sequi modi officia odio praesentium, illum, voluptate officiis aliquam doloribus laudantium nam ratione dicta neque esse, rem blanditiis eius. Perferendis....</p>
                                </div>
                                <div class="typography-line">
                                    <span>Info Text</span>
                                    <p class="text-info">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur eum aliquam rerum laborum hic, officia provident, ipsum, rem accusantium ducimus numquam in deserunt quia maxime enim neque molestiae perferendis nesciunt!... </p>
                                </div>
                                <div class="typography-line">
                                    <span>Success Text</span>
                                    <p class="text-success">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, consequatur dolor totam quasi ut, ipsam pariatur quae eaque quaerat, quos qui vel necessitatibus excepturi veniam a veritatis! Commodi, magni, libero.... </p>
                                </div>
                                <div class="typography-line">
                                    <span>Warning Text</span>
                                    <p class="text-warning">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, inventore, animi nemo impedit quos doloremque hic ipsum voluptatum beatae sequi, autem minus laborum aspernatur tempora a. Dolor, ad aut vitae....
                                    </p>
                                </div>
                                <div class="typography-line">
                                    <span>Danger Text</span>
                                    <p class="text-danger">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium id, iusto vero iure libero optio, provident alias accusamus suscipit doloremque labore voluptate. Labore aperiam facere, sequi fugit alias. Accusantium, in!... </p>
                                </div>
                                <div class="typography-line">
                                    <h2>
                                        <span>Etiqueta pequeña</span>
                                        Encabezado con subtitulo "small"
                                        <br>
                                        <small>Usa la etiqueta "small" para los encabezados</small>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
