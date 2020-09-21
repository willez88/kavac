@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/budget/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/budget/css/app.css'), ['media' => 'screen'], Request::secure()) !!}
@endsection
