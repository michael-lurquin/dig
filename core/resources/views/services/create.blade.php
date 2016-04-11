@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Création</h1>
</div>

{!! Form::open(['route' => 'service.store']) !!}

    @include('services.form')

{!! Form::close() !!}
@endsection
