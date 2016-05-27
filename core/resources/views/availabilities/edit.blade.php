@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Modification</h1>
    </div>

    {!! Form::model($availability, ['route' => ['availability.update', $availability->name], 'method' => 'PUT']) !!}

        @include('availabilities.form')

    {!! Form::close() !!}
@endsection
