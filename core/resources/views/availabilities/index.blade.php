@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="{{ route('availability.create') }}" class="btn btn-success pull-right">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouvelle disponibilitée
        </a>
        <h1>Liste des disponibilitées</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($availabilities as $availability)
                    <tr>
                      <td>{{ $availability->name }}</td>
                      <td>
                        <a href="{{ route('availability.edit', $availability->name) }}" class="btn btn-primary">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifier
                        </a>
                        <a href="#" data-toggle="modal" data-target="#myModal{{ $availability->id }}" class="btn btn-danger">
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                        </a>
                      </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">Aucune disponibilitée !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {!! $availabilities->render() !!}

    <!-- Modal -->
    @foreach ($availabilities as $availability)
        <div class="modal fade" id="myModal{{ $availability->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation de suppression</h4>
              </div>

              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer la disponibilitée : <strong>{{ $availability->name }}</strong> ?</p>
              </div>

              <div class="modal-footer">
                {!! Form::open(['route' => ['availability.destroy', $availability->name], 'method' => 'DELETE']) !!}
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
