<div class="panel panel-default">
  <div class="panel-heading">Informations</div>
  <div class="panel-body">

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} required">
      {{ Form::label('name', 'Nom', ['class' => 'control-label']) }}
      {{ Form::text('name', old('name'), ['class' => 'form-control', 'autofocus' => 'autofocus']) }}

      @if ($errors->has('name'))
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} required">
      {{ Form::label('email', 'Adresse email', ['class' => 'control-label']) }}
      {{ Form::email('email', old('email'), ['class' => 'form-control', isset($hasPermission) && !$hasPermission ? 'disabled' : NULL ]) }}

      @if ($errors->has('email'))
        <span class="help-block">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('poste') ? ' has-error' : '' }} required">
      {{ Form::label('poste', 'Poste', ['class' => 'control-label']) }}
      {{ Form::text('poste', old('poste'), ['class' => 'form-control', isset($hasPermission) && !$hasPermission ? 'disabled' : NULL ]) }}

      @if ($errors->has('poste'))
        <span class="help-block">
          <strong>{{ $errors->first('poste') }}</strong>
        </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }} required">
      {{ Form::label('role_id', 'Rôle', ['class' => 'control-label']) }}

      <div class="btn-group bootstrap-select" style="display:block">
        <select class="form-control selectpicker" data-width="250px" name="role_id"{{ isset($hasPermission) && !$hasPermission ? ' disabled' : ''}}>
          @foreach ($roles as $rid => $name)
            <option value="{{ $rid }}"{{ !empty($user) && $user->role_id == $rid ? ' selected' : '' }}>{{ ucfirst($name) }}</option>
          @endforeach
        </select>
      </div>

      @if ($errors->has('role_id'))
        <span class="help-block">
          <strong>{{ $errors->first('role_id') }}</strong>
        </span>
      @endif
    </div>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Mot de passe</div>
  <div class="panel-body">

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} {{ $isCreated ? 'required' : '' }}">
      {{ Form::label('password', 'Mot de passe', ['class' => 'control-label']) }}
      {{ Form::password('password', ['class' => 'form-control']) }}

      @if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
      @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} {{ $isCreated ? 'required' : '' }}">
      {{ Form::label('password_confirmation', 'Confirmation du mot de passe', ['class' => 'control-label']) }}
      {{ Form::password('password_confirmation', ['class' => 'form-control']) }}

      @if ($errors->has('password_confirmation'))
        <span class="help-block">
          <strong>{{ $errors->first('password_confirmation') }}</strong>
        </span>
      @endif
    </div>

  </div>
</div>

<a href="{{ isset($hasPermission) && $hasPermission ? route('user.index') : route('dashboard') }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Annuler</a>
{{ Form::submit('Enregistrer', ['class' => 'btn btn-primary']) }}
