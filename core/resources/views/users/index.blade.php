@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="{{ route('user.create') }}" class="btn btn-success pull-right">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouvel utilisateur
        </a>
        @if ( Auth::user()->can('manage_permissions') )
          <a href="{{ route('permission.index') }}" class="btn btn-info pull-right" style="margin-right:7px">
              <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Gestion des permissions
          </a>
        @endif
        <h1>Liste des utilisateurs</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="{{ !$user->active ? 'danger' : '' }}">
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ ucfirst($user->role->name) }}</td>
                      <td>{{ $user->created_at }}</td>
                      <td>
                        @if ($user->active)
                          <a href="{{ route('user.edit', $user->email) }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifier
                          </a>
                          <a href="#" data-toggle="modal" data-target="#myModal{{ $user->id }}" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                          </a>
                        @else
                          <a href="{{ action('UserController@restore', ['user' => $user->email]) }}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Restaurer
                          </a>
                        @endif
                      </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">Aucun utilisateur !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {!! $users->render() !!}

    <!-- Modal -->
    @foreach ($users as $user)
        <div class="modal fade" id="myModal{{ $user->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation de suppression</h4>
              </div>

              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer l'utilisateur : <strong>{{ $user->name }}</strong> ?</p>
              </div>

              <div class="modal-footer">
                {!! Form::model($user, ['route' => ['user.destroy', $user->email], 'method' => 'DELETE']) !!}
                  <button type="submit" class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                  </button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                {!! Form::close() !!}
              </div>

            </div>

          </div>
        </div>
    @endforeach
@endsection
