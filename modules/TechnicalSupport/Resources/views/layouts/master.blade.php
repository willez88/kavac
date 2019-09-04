@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/$LOWER_NAME$/js/app.js'), [], Request::secure()) !!}
@endsection
