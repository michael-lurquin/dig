@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Modification</h1>
    </div>

    {!! Form::model($user, ['route' => ['user.update', $user->email], 'method' => 'PUT']) !!}

        @include('users.form', ['isCreated' => FALSE])

    {!! Form::close() !!}
@endsection
