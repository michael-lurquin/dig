@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1>{{ $service->title }} <small>{{ $service->identifier }}</small></h1>
    </div>

    <h4>Disponibilité:</h4>
    @if (!empty($service->availability_id))
      <p>{{ $service->availability->name }}</p>
    @endif

    <br />

    <div class="page-header text-right">
        <h3>Decription du service</h3>
    </div>

    <h4>Catégorie(s):</h4>
    <ul>
      @forelse($service->categories as $category)
        <li>{{ $category->name }}</li>
      @empty
        <li>Aucune catégorie</li>
      @endforelse
    </ul>

    <h4>Description de(s) (la) catégorie(s):</h4>
    @if (!empty($service->description_categorie))
      <p>{{ $service->description_categorie }}</p>
    @endif

    <h4>Contexte:</h4>
    @if (!empty($service->contexte))
      <p>{{ $service->contexte }}</p>
    @endif

    <h4>Description:</h4>
    @if (!empty($service->description))
      <p>{{ $service->description }}</p>
    @endif

    <h4>Éléments exclus du primètre:</h4>
    @if (!empty($service->exclus_perimetre))
      <p>{{ $service->exclus_perimetre }}</p>
    @endif

    <h4>Prérequis:</h4>
    @if (!empty($service->prerequis))
      <p>{{ $service->prerequis }}</p>
    @endif

    <h4>Contact général:</h4>
    @if (!empty($service->contact_general))
      <p>{{ $service->contact_general }}</p>
    @endif

    <div class="page-header text-right">
        <h3>Délais et coûts</h3>
    </div>

    <h4>Coût pour le client:</h4>
    @if (!empty($service->cout_client))
      <p>{{ $service->cout_client }} €</p>
    @endif

    <h4>Délai de prise en charge:</h4>
    @if (!empty($service->delai_charge))
      <p>{{ $service->delai_charge }} jour(s)</p>
    @endif

    <h4>Délai de mise en oeuvre par la DIG:</h4>
    @if (!empty($service->delai_oeuvre))
      <p>{{ $service->delai_oeuvre }} jour(s)</p>
    @endif

    <h4>Délai dépendant de tiers:</h4>
    @if (!empty($service->delai_tiers))
      <p>{{ $service->delai_tiers }} jour(s)</p>
    @endif

    <h4>Marge de sécurité:</h4>
    @if (!empty($service->marge_securite))
      <p>{{ $service->marge_securite }} jour(s)</p>
    @endif

    <h4>Délai de réalisation:</h4>
    @if (!empty($service->getDelaiRealisation()))
      <p>{{ $service->getDelaiRealisation() }} jour(s)</p>
    @endif

    <h4>Remarque éventuelle sur le délai de réalisation:</h4>
    @if (!empty($service->remarque_delai))
      <p>{{ $service->remarque_delai }}</p>
    @endif

    <h4>RH interne:</h4>
    @if (!empty($service->rh_interne))
      <p>{{ $service->rh_interne }}</p>
    @endif

    <h4>Coût d'externalisation:</h4>
    @if (!empty($service->cout_externalisation))
      <p>{{ $service->cout_externalisation }} €</p>
    @endif

    <div class="page-header text-right">
        <h3>Intervenants et procédure</h3>
    </div>

    <h4>Agent DIG responsable:</h4>
    @if (!empty($service->agent_responsable))
      <p>{{ \App\User::findOrFail($service->agent_responsable)->name }}</p>
    @endif

    <h4>Agent DIG responsable suppléant:</h4>
    <ul>
      @forelse($service->ars as $user)
        <li>{{ $user->name }}</li>
      @empty
        <li>Aucun</li>
      @endforelse
    </ul>

    <h4>Autres agents DIG impliqués:</h4>
    <ul>
      @forelse($service->aai as $user)
        <li>{{ $user->name }}</li>
      @empty
        <li>Aucun</li>
      @endforelse
    </ul>

    <h4>Intervenants externes:</h4>
    @if (!empty($service->intervenants_externes))
      <p>{{ $service->intervenants_externes }}</p>
    @endif

    <h4>Identifiant procédure:</h4>
    @if (!empty($service->identifiant_procedure))
      <p>{{ $service->identifiant_procedure }}</p>
    @endif

    <h4>Résumé de la procédure:</h4>
    @if (!empty($service->resume_procedure))
      <p>{{ $service->resume_procedure }}</p>
    @endif

    <blockquote class="pull-right">
      <p>{{ \App\User::findOrFail($service->user_id)->name }}, le {{ date_format($service->created_at, 'd/m/Y') }} à {{ date_format($service->created_at, 'H:i') }}</p>
    </blockquote>

    <br />
    <a href="{{ route('service.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Retour</a>

@endsection
