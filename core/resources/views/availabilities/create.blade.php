@extends('layouts.app')

@section('content')
  <div class="page-header">
      <h1>Création</h1>
  </div>

  {!! Form::open(['route' => 'availability.store']) !!}

      @include('availabilities.form')

  {!! Form::close() !!}
@endsection
