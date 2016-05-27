@extends('layouts.app')

@section('content')
  <div class="page-header">
      <h1>Création</h1>
  </div>

  {!! Form::open(['route' => 'user.store']) !!}

      @include('users.form', ['isCreated' => TRUE])

  {!! Form::close() !!}
@endsection
