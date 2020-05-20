@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/finance/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/finance/css/app.css'), [], Request::secure()) !!}
@endsection
