@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="{{ route('service.create') }}" class="btn btn-success pull-right">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouveau service
        </a>
        <h1>Liste des services</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Identifiant</th>
                    <th>Date de modification</th>
                    <th>Auteur</th>
                    <th style="min-width:430px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr class="{{ $service->trashed() ? 'danger' : '' }}">
                        <td>
                            <a href="{{ route('service.show', $service->slug) }}">{{ $service->title }}</a>
                        </td>
                        <td>DIG-CATEG-{{ $service->identifier }}</td>
                        <td>{{ $service->updated_at }}</td>
                        <td>{{ $service->user->name }}</td>
                        <td>
                          <a href="{{ action('ServiceController@export', ['service' => $service->slug]) }}" class="btn btn-warning">
                              <i class="fa fa-file-word-o" aria-hidden="true"></i> Exporter
                          </a>
                        	@if ( !$service->trashed() )
                            <a href="{{ route('service.revisions', $service->slug) }}" class="btn btn-info">
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Révisions
                            </a>
                            <a href="{{ route('service.edit', $service->slug) }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifier
                            </a>
                            @if ( Auth::user()->can('service_delete') )
                                <a href="#" data-toggle="modal" data-target="#myModal{{ $service->id }}" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                                </a>
                            @endif
                          @else
                            @if ( Auth::user()->can('service_restore') )
                            <a href="{{ action('ServiceController@restore', ['service' => $service->slug]) }}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Restaurer
                            </a>
                            @endif
                          @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" align="center">Aucun service !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @foreach ($services as $service)
        <div class="modal fade" id="myModal{{ $service->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation de suppression</h4>
              </div>

              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer le service : <strong>{{ $service->title }}</strong> ?</p>
              </div>

              <div class="modal-footer">
                {!! Form::model($service, ['route' => ['service.destroy', $service->slug], 'method' => 'DELETE']) !!}
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
