@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h1>Dashboard</h1>
  </div>

  <div class="row">

    @if ( Auth::user()->can('service_create') )
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $services }}</div>
                        <div>Services</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('service.index') }}">
                <div class="panel-footer">
                    <span class="pull-left">Gestion des services</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if ( Auth::user()->can('manage_users') )
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $users }}</div>
                        <div>Utilisateurs</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.index') }}">
                <div class="panel-footer">
                    <span class="pull-left">Gestion des utilisateurs</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if ( Auth::user()->can('manage_availabilities') )
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-hourglass-start fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $availabilities }}</div>
                        <div>Disponibilitées</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('availability.index') }}">
                <div class="panel-footer">
                    <span class="pull-left">Gestion des disponibilitées</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if ( Auth::user()->can('manage_categories') )
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tags fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ $categories }}</div>
                        <div>Catégories</div>
                    </div>
                </div>
            </div>
            <a href="{{ route('category.index') }}">
                <div class="panel-footer">
                    <span class="pull-left">Gestion des catégories</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    @endif

  </div>
@endsection
