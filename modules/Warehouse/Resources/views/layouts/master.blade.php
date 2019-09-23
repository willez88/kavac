@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/warehouse/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/warehouse/css/app.css'), [], Request::secure()) !!}
@endsection
