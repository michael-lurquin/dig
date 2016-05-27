@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h1>Bienvenue</h1>
  </div>
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">Offre de services de la DIG</div>
              <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                                <tr>
                                    <td>
                                        <a href="{{ route('service.show', $service->slug) }}">{{ $service->title }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ action('ServiceController@export', ['service' => $service->slug]) }}" class="btn btn-primary">
                                            <i class="fa fa-file-word-o" aria-hidden="true"></i> Exporter
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" align="center">Aucun service !</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
              </div>
          </div>
      </div>
  </div>
@endsection
