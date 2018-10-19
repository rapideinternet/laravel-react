@extends('partial-react.layout.index')

@section('content')
    <h3>Partial react application</h3>

    @reactComponent('articles', ['articles' => $articles->toArray()])

@endsection

