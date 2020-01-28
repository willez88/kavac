@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/technicalsupport/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/technicalsupport/css/app.css'), [], Request::secure()) !!}
@endsection

