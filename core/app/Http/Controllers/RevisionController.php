<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Revision;
use App\Service;

class RevisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:revision_validate', ['only' => 'valid']);
        $this->middleware('permission:revision_delete', ['only' => 'destroy']);
        $this->middleware('permission:revision_restore', ['only' => 'restore']);
    }

    public function index($slug)
    {
        $service = Service::with('revisions')->whereSlug($slug)->first();

        // Les lignes suivantes ne sont pas nécessaire mais permette de diminuer le nombre de requête
        $users = \App\User::lists('name', 'id')->toArray();
        foreach ($service->revisions as $revision)
        {
            $revision->user_id = isset($users[$revision->user_id]) ? $users[$revision->user_id] : '-';
        }
        $service->user_id = isset($users[$service->user_id]) ? $users[$service->user_id] : '-';

        return view('services.revisions')->withService($service);
    }

    public function valid(Request $request, $slug, $id)
    {
        $revision = Revision::findOrFail($id);
        $revision->valid = TRUE;
        $revision->user_id = $request->user()->id;
        $revision->save();

        $service = Service::whereSlug($slug)->first();
        $service->{$revision->field} = $revision->new_value;
        $service->save();

        $revisions = Revision::whereServiceId($revision->service_id)->whereField($revision->field)->whereNotIn('id', [$id])->delete();

        $fieldFormatter = $revision->getField();

        return redirect()->route('service.revisions', $service->slug)->withSuccess("La validation du champ : <strong>$fieldFormatter</strong> à la valeur : <strong>$revision->new_value</strong> à été validé avec succès");
    }

    public function restore($slug, $id)
    {
        $revision = Revision::findOrFail($id);

        $service = Service::whereSlug($slug)->first();
        $service->{$revision->field} = $revision->old_value;
        $service->save();

        $fieldFormatter = $revision->getField();

        $revision->delete();

        return redirect()->route('service.revisions', $service->slug)->withSuccess("La restauration du champ : <strong>$fieldFormatter</strong> à la valeur : <strong>$revision->old_value</strong> à effectuée avec succès");
    }

    public function destroy($id)
    {
        $revision = Revision::with('user')->findOrFail($id);
        $service = Service::findOrFail($revision->service_id);

        $author = $revision->user->name;

        $revision->delete();

        return redirect()->route('service.revisions', $service->slug)->withSuccess("La révision de <strong>$author</strong> a été supprimée avec succès");
    }
}
