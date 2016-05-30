@extends('layouts.app')

@section('content')
    <div class="page-header">
        <a href="{{ route('category.create') }}" class="btn btn-success pull-right">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nouvelle catégorie
        </a>
        <h1>Liste des catégories</h1>
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
                @forelse ($categories as $category)
                    <tr>
                      <td>{{ $category->name }}</td>
                      <td>
                        <a href="{{ route('category.edit', $category->name) }}" class="btn btn-primary">
                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Modifier
                        </a>
                        <a href="#" data-toggle="modal" data-target="#myModal{{ $category->id }}" class="btn btn-danger">
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Supprimer
                        </a>
                      </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">Aucune catégorie !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {!! $categories->render() !!}

    <!-- Modal -->
    @foreach ($categories as $category)
        <div class="modal fade" id="myModal{{ $category->id }}" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation de suppression</h4>
              </div>

              <div class="modal-body">
                <p>Voulez-vous vraiment supprimer la catégorie : <strong>{{ $category->name }}</strong> ?</p>
              </div>

              <div class="modal-footer">
                {!! Form::open(['route' => ['category.destroy', $category->name], 'method' => 'DELETE']) !!}
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
