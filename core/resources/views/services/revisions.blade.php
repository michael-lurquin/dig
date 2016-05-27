@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>Révisions</h1>
    </div>
    <p>Les lignes en jaunes signalent des opérations importantes, celles en vertes sont validées et les autres sont en attente de validation.</p>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Nom</th>
                    <th>Champ</th>
                    <th>Ancienne valeur</th>
                    <th>Nouvelle valeur</th>
                    <th>Auteur</th>
                    <th>Date de l'opération</th>
                    <th width="165">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($service->revisions as $revision)
                    @if ($revision->field == 'created_at')
                        <tr class="warning">
                            <td>Création</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $service->user_id }}</td>
                            <td>{{ $service->created_at->format('d/m/Y H:i:s') }}</td>
                            <td></td>
                        </tr>
                    @else
                        <tr class="{{ $revision->valid ? 'success' : '' }}">
                            <td>{{ $revision->field == 'deleted_at' ? 'Suppression' : 'Modification' }}</td>
                            <td>{{ $revision->name }}</td>
                            <td>{{ $revision->getField() }}</td>
                            <td>{{ !is_null($revision->old_value) ? $revision->getValue($revision->old_value) : '-' }}</td>
                            <td>{{ !is_null($revision->new_value) ? $revision->getValue($revision->new_value) : '-' }}</td>
                            <td>{{ $revision->user_id }}</td>
                            <td>{{ $revision->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @if (!$revision->valid)
                                    @if (Auth::user()->can('revision_validate'))
                                        <a href="{{ action('RevisionController@valid', ['service' => $service->slug, 'id' => $revision->id]) }}" class="btn btn-success">
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Valider
                                        </a>
                                    @endif
                                    @if (Auth::user()->can('revision_delete'))
                                        <a href="#" data-toggle="modal" data-target="#myModal{{ $revision->id }}" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </a>
                                    @endif
                                @else
                                    @if (Auth::user()->can('revision_restore'))
                                        <a href="{{ action('RevisionController@restore', ['service' => $service->slug, 'id' => $revision->id]) }}" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Restaurer
                                        </a>
                                    @endif
                                    @if (Auth::user()->can('revision_delete'))
                                        <a href="#" data-toggle="modal" data-target="#myModal{{ $revision->id }}" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" align="center">Aucun historique !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @foreach ($service->revisions as $revision)
        <div class="modal fade" id="myModal{{ $revision->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation de suppression</h4>
              </div>

              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer la révision de <strong>{{ $revision->user_id }}</strong> ?</p>
              </div>

              <div class="modal-footer">
                {!! Form::model($revision, ['route' => ['revision.destroy', $revision->id], 'method' => 'DELETE']) !!}
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

    <a href="{{ route('service.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Retour</a>
@endsection
