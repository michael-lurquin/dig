<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingIdentifiant">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseIdentifiant" aria-expanded="true" aria-controls="collapseIdentifiant">
          Identifiant du service
        </a>
      </h4>
    </div>
    <div id="collapseIdentifiant" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingIdentifiant">
      <div class="panel-body">

        <div class="form-group{{ $errors->has('identifier') ? ' has-error' : '' }} required">
          {{ Form::label('identifier', 'Numéro unique', ['class' => 'control-label']) }}
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon_1">DIG-CATEG-</span>
            {{ Form::text('identifier', old('identifier'), ['class' => 'form-control', 'aria-describedby' => 'identifier', 'autofocus' => 'autofocus', 'placeholder' => 'Identifiant unique du service']) }}
          </div>

          @if ($errors->has('identifier'))
              <span class="help-block">
                  <strong>{{ $errors->first('identifier') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }} required">
          {{ Form::label('title', 'Titre', ['class' => 'control-label']) }}
          {{ Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Titre du service']) }}

          @if ($errors->has('title'))
              <span class="help-block">
                  <strong>{{ $errors->first('title') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
          {{ Form::label('slug', 'URL du service', ['class' => 'control-label']) }}
          {{ Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => 'Titre du service utilisé dans l\'URL']) }}

          @if ($errors->has('slug'))
              <span class="help-block">
                  <strong>{{ $errors->first('slug') }}</strong>
              </span>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingDisponibilite">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDisponibilite" aria-expanded="false" aria-controls="collapseDisponibilite">
          Disponibilité du service
        </a>
      </h4>
    </div>
    <div id="collapseDisponibilite" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDisponibilite">
      <div class="panel-body">

        <div class="block_center form-group{{ $errors->has('availability_id') ? ' has-error' : '' }} required">
          {{ Form::label('availability_id', 'Statut', ['class' => 'control-label dispo']) }}

          <div class="btn-group dispo-btn" data-toggle="buttons">

            @foreach ($availability as $id => $name)
              <label class="btn btn-default{{ isset($service->availability_id) && $service->availability_id == $id ? ' active' : '' }}">
                {{ Form::radio('availability_id', $id, isset($service->availability_id) && $service->availability_id == $id ? true : false) }} {{ ucfirst($name) }}
              </label>
            @endforeach

            <br />
            <small class="info">Choisissez une seule option parmi celles ci-dessus</small>
          </div>

          @if ($errors->has('availability_id'))
              <span class="help-block">
                  <strong>{{ $errors->first('availability_id') }}</strong>
              </span>
          @endif
        </div>


      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingDescription">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
          Description du service
        </a>
      </h4>
    </div>
    <div id="collapseDescription" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDescription">
      <div class="panel-body">

        <div class="block_center form-group{{ $errors->has('category_id') ? ' has-error' : '' }} required">
          {{ Form::label('category_id', 'Catégorie', ['class' => 'control-label dispo']) }}

          <div class="btn-group-vertical" data-toggle="buttons">
            <?php $i = 0; ?>
            @foreach ($categories as $id => $name)
              <?php $checked = FALSE; ?>
              @if ( isset($service) && in_array($id, $service->categories_used) )
                <?php $checked = TRUE; ?>
              @endif
              <?php $i++; ?>
              <label class="btn btn-default{{ $checked == TRUE ? ' active' : '' }}{{ count($categories) == $i ? ' last-btn' : '' }}">
                {{ Form::checkbox('category_id[]', $id, $checked) }} {{ $name }}
              </label>

            @endforeach

            <small class="info">Choisissez une ou plusieurs catégories parmi celles ci-dessus</small>
          </div>

          @if ($errors->has('category_id'))
              <span class="help-block">
                  <strong>{{ $errors->first('category_id') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('description_categorie') ? ' has-error' : '' }}">
          {{ Form::label('description_categorie', 'Description de(s) (la) catégorie(s)', ['class' => 'control-label']) }}
          {{ Form::textarea('description_categorie', old('description_categorie'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Brève description de la catégorie']) }}

          @if ($errors->has('description_categorie'))
              <span class="help-block">
                  <strong>{{ $errors->first('description_categorie') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('contexte') ? ' has-error' : '' }}">
          {{ Form::label('contexte', 'Contexte', ['class' => 'control-label']) }}
          {{ Form::textarea('contexte', old('contexte'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Décrivez brièvement le contexte général dans lequel s\'inscrit le service']) }}

          @if ($errors->has('contexte'))
              <span class="help-block">
                  <strong>{{ $errors->first('contexte') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
          {{ Form::label('description', 'Description du service', ['class' => 'control-label']) }}
          {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Description du service']) }}

          @if ($errors->has('description'))
              <span class="help-block">
                  <strong>{{ $errors->first('description') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('exclus_perimetre') ? ' has-error' : '' }}">
          {{ Form::label('exclus_perimetre', 'Éléments exclus du primètre', ['class' => 'control-label']) }}
          {{ Form::textarea('exclus_perimetre', old('exclus_perimetre'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Décrivez les tâches qui ne sont pas effectuées dans le cadre du service']) }}

          @if ($errors->has('exclus_perimetre'))
              <span class="help-block">
                  <strong>{{ $errors->first('exclus_perimetre') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('prerequis') ? ' has-error' : '' }}">
          {{ Form::label('prerequis', 'Prérequis', ['class' => 'control-label']) }}
          {{ Form::textarea('prerequis', old('prerequis'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Décrivez les prérequis nécessaires à la mise en oeuvre du présent service']) }}

          @if ($errors->has('prerequis'))
              <span class="help-block">
                  <strong>{{ $errors->first('prerequis') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('contact_general') ? ' has-error' : '' }}">
          {{ Form::label('contact_general', 'Contact général', ['class' => 'control-label']) }}
          {{ Form::textarea('contact_general', old('contact_general'), ['class' => 'form-control', 'rows' => 5]) }}

          <small class"info">Pour plus d'information sur ce service, veuillez nous contacter au travers du formulaire de contact du <a href="http://geoportail.wallonie.be/contact">Géoportail de la Wallonie</a></small>

          @if ($errors->has('contact_general'))
              <span class="help-block">
                  <strong>{{ $errors->first('contact_general') }}</strong>
              </span>
          @endif
        </div>

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingDelaisCouts">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDelaisCouts" aria-expanded="false" aria-controls="collapseDelaisCouts">
          Délais et coûts
        </a>
      </h4>
    </div>
    <div id="collapseDelaisCouts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingDelaisCouts">
      <div class="panel-body">

        <div class="form-group{{ $errors->has('cout_client') ? ' has-error' : '' }}">
          {{ Form::label('cout_client', 'Coût pour le client', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('cout_client', old('cout_client'), ['class' => 'form-control', 'aria-describedby' => 'cout_client', 'placeholder' => 'Citez le montant (TVAC) à charge du client']) }}
            <span class="input-group-addon" id="basic-addon_2">€</span>
          </div>

          <small class="info">Si c'est gratuit, écrivez "Gratuit"</small>

          @if ($errors->has('cout_client'))
              <span class="help-block">
                  <strong>{{ $errors->first('cout_client') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('delai_charge') ? ' has-error' : '' }} required">
          {{ Form::label('delai_charge', 'Délai de prise en charge', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('delai_charge', old('delai_charge'), ['class' => 'form-control', 'aria-describedby' => 'delai_charge', 'placeholder' => 'Mentionnez le délai nécessaire à une pré-analyse et à une pré-validation de la demande']) }}
            <span class="input-group-addon" id="basic-addon_3">jour(s)</span>
          </div>

          <small class="info">En jours ouvrables (exemple: 3.5)</small>

          @if ($errors->has('delai_charge'))
              <span class="help-block">
                  <strong>{{ $errors->first('delai_charge') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('delai_oeuvre') ? ' has-error' : '' }} required">
          {{ Form::label('delai_oeuvre', 'Délai de mise en oeuvre par la DIG', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('delai_oeuvre', old('delai_oeuvre'), ['class' => 'form-control', 'aria-describedby' => 'delai_oeuvre', 'placeholder' => 'Mentionnez le temps de travail effectif pour la DIG pour la réalisation du service']) }}
            <span class="input-group-addon" id="basic-addon_4">jour(s)</span>
          </div>

          <small class="info">En jours ouvrables (exemple: 3.5)</small>

          @if ($errors->has('delai_oeuvre'))
              <span class="help-block">
                  <strong>{{ $errors->first('delai_oeuvre') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('delai_tiers') ? ' has-error' : '' }} required">
          {{ Form::label('delai_tiers', 'Délai dépendant de tiers', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('delai_tiers', old('delai_tiers'), ['class' => 'form-control', 'aria-describedby' => 'delai_tiers', 'placeholder' => 'Mentionnez le délai imposés par des tiers']) }}
            <span class="input-group-addon" id="basic-addon_5">jour(s)</span>
          </div>

          <small class="info">En jours ouvrables (exemple: 3.5)</small>

          @if ($errors->has('delai_tiers'))
              <span class="help-block">
                  <strong>{{ $errors->first('delai_tiers') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('marge_securite') ? ' has-error' : '' }} required">
          {{ Form::label('marge_securite', 'Marge de sécurité', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('marge_securite', old('marge_securite'), ['class' => 'form-control', 'aria-describedby' => 'marge_securite', 'placeholder' => 'Mentionnez une marge de sécurité']) }}
            <span class="input-group-addon" id="basic-addon_6">jour(s)</span>
          </div>

          <small class="info">En jours ouvrables (exemple: 3.5)</small>

          @if ($errors->has('marge_securite'))
              <span class="help-block">
                  <strong>{{ $errors->first('marge_securite') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('delai_realisation') ? ' has-error' : '' }}">
          {{ Form::label('delai_realisation', 'Délai de réalisation', ['class' => 'control-label']) }}
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon_7">Total</span>
            {{ Form::text('delai_realisation', old('delai_realisation'), ['class' => 'form-control', 'aria-describedby' => 'delai_realisation', 'disabled', 'placeholder' => 'Somme des délais précédents']) }}
            <span class="input-group-addon" id="basic-addon_8">jour(s)</span>
          </div>

          @if ($errors->has('delai_realisation'))
              <span class="help-block">
                  <strong>{{ $errors->first('delai_realisation') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('remarque_delai') ? ' has-error' : '' }}">
          {{ Form::label('remarque_delai', 'Remarque éventuelle sur le délai de réalisation', ['class' => 'control-label']) }}
          {{ Form::textarea('remarque_delai', old('remarque_delai'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Remarque éventuelle sur le délai de réalisation']) }}

          @if ($errors->has('remarque_delai'))
              <span class="help-block">
                  <strong>{{ $errors->first('remarque_delai') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('rh_interne') ? ' has-error' : '' }} required">
          {{ Form::label('rh_interne', 'RH interne', ['class' => 'control-label']) }}
          {{ Form::textarea('rh_interne', old('rh_interne'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Précisez les ressources humaines dédiées à la réalisation d\'une occurence du service']) }}

          @if ($errors->has('rh_interne'))
              <span class="help-block">
                  <strong>{{ $errors->first('rh_interne') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('cout_externalisation') ? ' has-error' : '' }}">
          {{ Form::label('cout_externalisation', 'Coût d\'externalisation', ['class' => 'control-label']) }}
          <div class="input-group">
            {{ Form::text('cout_externalisation', old('cout_externalisation'), ['class' => 'form-control', 'aria-describedby' => 'cout_externalisation', 'placeholder' => 'Précisez le coût (TVAC), à charge de la DIG, pour la réalisation d\'une occurence du service']) }}
            <span class="input-group-addon" id="basic_addon_9">€</span>
          </div>

          @if ($errors->has('cout_externalisation'))
              <span class="help-block">
                  <strong>{{ $errors->first('cout_externalisation') }}</strong>
              </span>
          @endif
        </div>

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingIntervenantsProcedure">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseIntervenantsProcedure" aria-expanded="false" aria-controls="collapseIntervenantsProcedure">
          Intervenants et procédure
        </a>
      </h4>
    </div>
    <div id="collapseIntervenantsProcedure" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIntervenantsProcedure">
      <div class="panel-body">

        <div class="form-group{{ $errors->has('agent_responsable') ? ' has-error' : '' }} required">
          {{ Form::label('agent_responsable', 'Agent DIG responsable', ['class' => 'control-label']) }}

            <div class="btn-group bootstrap-select" style="display:block">
              <select class="form-control selectpicker" data-width="250px" name="agent_responsable">
                @foreach($users as $user)
                  <option data-subtext="{{ $user->poste }}" value="{{ $user->id }}" {{ !empty($service) && $user->id == $service->agent_responsable ? 'selected' : NULL }}>{{ $user->name }}</option>
                @endforeach
              </select>
            </div>

          @if ($errors->has('agent_responsable'))
              <span class="help-block">
                  <strong>{{ $errors->first('agent_responsable') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('agent_responsable_suppleant') ? ' has-error' : '' }} required">
          {{ Form::label('agent_responsable_suppleant', 'Agent DIG responsable suppléant', ['class' => 'control-label']) }}

          <div class="btn-group bootstrap-select" style="display:block">
            <select class="form-control selectpicker" multiple data-width="550px" name="agent_responsable_suppleant[]">
              @foreach($users as $user)
                <option data-subtext="{{ $user->poste }}" value="{{ $user->id }}" {{ isset($service) && in_array($user->id, $service->ars) ? 'selected' : NULL }}>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <small class="info">Choisissez un ou plusieurs agent(s) responsable(s) en cas d'absence du responsable parmi ceux ci-dessus</small>

          @if ($errors->has('agent_responsable_suppleant'))
              <span class="help-block">
                  <strong>{{ $errors->first('agent_responsable_suppleant') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('autres_agents') ? ' has-error' : '' }}">
          {{ Form::label('autres_agents', 'Autres agents DIG impliqués', ['class' => 'control-label']) }}

          <div class="btn-group bootstrap-select" style="display:block">
            <select class="form-control selectpicker" multiple data-width="550px" name="autres_agents[]">
              @foreach($users as $user)
                <option data-subtext="{{ $user->poste }}" value="{{ $user->id }}" {{ isset($service) && in_array($user->id, $service->aai) ? 'selected' : NULL }}>{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <small class="info">Choisissez un ou plusieurs agent(s) impliqué(s) dans la réalisation du service parmi ceux ci-dessus</small>

          @if ($errors->has('autres_agents'))
              <span class="help-block">
                  <strong>{{ $errors->first('autres_agents') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('intervenants_externes') ? ' has-error' : '' }}">
          {{ Form::label('intervenants_externes', 'Intervenants externes', ['class' => 'control-label']) }}
          {{ Form::textarea('intervenants_externes', old('intervenants_externes'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Citez les intervenants externes à la DIG']) }}

          @if ($errors->has('intervenants_externes'))
              <span class="help-block">
                  <strong>{{ $errors->first('intervenants_externes') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('identifiant_procedure') ? ' has-error' : '' }}">
          {{ Form::label('identifiant_procedure', 'Identifiant procédure', ['class' => 'control-label']) }}
          {{ Form::textarea('identifiant_procedure', old('identifiant_procedure'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Citez l\'identifiant et le chemin d\'accès au document principal qui décrit la procédure/workflow de réalisation du service']) }}

          @if ($errors->has('identifiant_procedure'))
              <span class="help-block">
                  <strong>{{ $errors->first('identifiant_procedure') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('resume_procedure') ? ' has-error' : '' }}">
          {{ Form::label('resume_procedure', 'Résumé de la procédure', ['class' => 'control-label']) }}
          {{ Form::textarea('resume_procedure', old('resume_procedure'), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Citez les étapes clés de la procédure afin que le client puisse avoir une vue d\'ensemble de la procédure']) }}

          @if ($errors->has('resume_procedure'))
              <span class="help-block">
                  <strong>{{ $errors->first('resume_procedure') }}</strong>
              </span>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>

<small>Les champs marqués d'un astérisque (*) sont obligatoires.</small>
<br /><br />

<a href="{{ route('service.index') }}" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Annuler</a>
