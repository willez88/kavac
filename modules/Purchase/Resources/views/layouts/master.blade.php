@extends('layouts.app')

@section('maproute-icon')
    @parent
@endsection

@section('maproute-icon-mini')
    @parent
@endsection

@section('maproute-actual')
    @parent
@endsection

@section('maproute-title')
    @parent
@endsection

@section('content')
    @parent
@endsection

@section('module-css')
    {!! Html::style(mix('css/purchase.css'), [], Request::secure()) !!}
@endsection

@section('app-js')
    {!! Html::style(mix('js/purchase.js'), [], Request::secure()) !!}
@endsection
