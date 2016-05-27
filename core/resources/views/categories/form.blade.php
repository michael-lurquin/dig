<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} required">
  {{ Form::label('name', 'Nom', ['class' => 'control-label']) }}
  {{ Form::text('name', old('name'), ['class' => 'form-control', 'autofocus' => 'autofocus']) }}

  @if ($errors->has('name'))
    <span class="help-block">
      <strong>{{ $errors->first('name') }}</strong>
    </span>
  @endif
</div>

{{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
