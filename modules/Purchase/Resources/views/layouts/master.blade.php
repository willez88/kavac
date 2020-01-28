@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/purchase/js/app.js'), [], Request::secure()) !!}
@endsection
@section('modules-css')
    @parent
    {!! Html::style(mix('modules/purchase/css/app.css'), [], Request::secure()) !!}
@endsection
