@extends('laravel.layout.index')

@section('content')
    <h3>Laravel MVC application</h3>

    @react_component('Button', ['name' => 'Testron'])
@endsection
