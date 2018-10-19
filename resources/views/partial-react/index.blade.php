@extends('partial-react.layout.index')
@section('content')
    <h3>Partial react application</h3>
    <div id="blog"></div>
    @reactComponent('Blog', ['test'=>'11','test2'=>'22'])
    @reactComponent('Blog', ['test'=>'55','test2'=>'66'])
@endsection
