@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/asset/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    @if(!isset($setting_view))
        {!! Html::style(mix('modules/asset/css/app.css'), [], Request::secure()) !!}
    @endif
@endsection
