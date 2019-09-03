@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/accounting/js/app.js'), [], Request::secure()) !!}
@endsection
