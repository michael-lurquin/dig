<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }} required">
  {{ Form::label('title', 'Titre', ['class' => 'control-label']) }}
  {{ Form::text('title', old('title'), ['class' => 'form-control']) }}

  @if ($errors->has('title'))
      <span class="help-block">
          <strong>{{ $errors->first('title') }}</strong>
      </span>
  @endif
</div>

<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
  {{ Form::label('slug', 'URL du service', ['class' => 'control-label']) }}
  {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}

  @if ($errors->has('slug'))
      <span class="help-block">
          <strong>{{ $errors->first('slug') }}</strong>
      </span>
  @endif
</div>

<a href="{{ route('service.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Annuler</a>
{{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
