@extends('layouts.app')

@section('content')
  <div class="page-header">
      <h1>Création</h1>
  </div>

  {!! Form::open(['route' => 'category.store']) !!}

      @include('categories.form')

  {!! Form::close() !!}
@endsection
