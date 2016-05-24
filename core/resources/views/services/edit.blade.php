@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Modification</h1>
    </div>

    {!! Form::model($service, ['route' => ['service.update', $service->slug], 'method' => 'PUT']) !!}

        @include('services.form')

        <a href="#" data-toggle="modal" data-target="#myModal{{ $service->id }}" class="btn btn-primary">
            Enregistrer
        </a>

        <div class="modal fade" id="myModal{{ $service->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Saississez un nom de version</h4>
              </div>

              <div class="modal-body">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} required">
                      {{ Form::label('name', 'Nom de version', ['class' => 'control-label']) }}
                      {{ Form::text('name', old('name'), ['class' => 'form-control', 'autofocus' => 'autofocus']) }}

                      @if ($errors->has('name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
              </div>

            </div>

          </div>
        </div>

    {!! Form::close() !!}
@endsection
