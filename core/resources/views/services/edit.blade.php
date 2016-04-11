@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Édition</h1>
    </div>

    {!! Form::model($service, ['route' => ['service.update', $service->slug], 'method' => 'PUT']) !!}

        @include('services.form')

    {!! Form::close() !!}
@endsection
