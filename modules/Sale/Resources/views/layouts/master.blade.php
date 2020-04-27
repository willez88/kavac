@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/sale/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/sale/css/app.css'), [], Request::secure()) !!}
@endsection
