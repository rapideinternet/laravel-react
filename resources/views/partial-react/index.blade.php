@extends('partial-react.layout.index')
@section('content')
    <h3>Partial react application</h3>
    <div id="blog"></div>
    @reactComponent('Blog', ['test'=>'value1','test2'=>'value2'])
@endsection
