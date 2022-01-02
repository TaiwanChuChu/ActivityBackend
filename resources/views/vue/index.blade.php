@extends('layouts.vue_template')

@section('content')
    <h1>Hello Vue</h1>
    <form-test csrf_token="{{ csrf_token() }}"/>

@endsection
