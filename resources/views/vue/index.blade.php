@extends('layouts.vue_template')

@section('content')
    <h1>Hello Vue</h1>
    <div class="BBB">START</div>
    {{--    <div>--}}
    {{--        <div>--}}
    {{--            <form-test csrf_token="{{ csrf_token() }}"/>--}}
    {{--        </div>--}}
    {{--        <div>--}}
    {{--            <about-us/>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div>
        <form-test csrf_token="{{ csrf_token() }}"/>
    </div>
    {{--    <div>--}}
    {{--        <merge />--}}
    {{--    </div>--}}
    <div class="BBB">END</div>
    blablabla...
@endsection
