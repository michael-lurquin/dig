@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Modification</h1>
    </div>

    {!! Form::model($category, ['route' => ['category.update', $category->name], 'method' => 'PUT']) !!}

        @include('categories.form')

    {!! Form::close() !!}
@endsection
