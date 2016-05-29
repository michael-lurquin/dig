<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\Service;

class ServiceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            // Création
            case 'POST':
            {
                return [
                    'title' => 'required|max:255|unique:services,title',
                    'slug' => 'unique:services,slug',
                    'identifier' => 'required|numeric|unique:services,identifier',
                    'availability_id' => 'required|exists:availabilities,id',
                    'category_id' => 'required|exists:categories,id',
                    'agent_responsable' => 'required|exists:users,id',
                    'agent_responsable_suppleant' => 'required|exists:users,id',
                    'autres_agents' => 'exists:users,id',
                    'delai_charge' => 'required|numeric',
                    'delai_oeuvre' => 'required|numeric',
                    'delai_tiers' => 'required|numeric',
                    'marge_securite' => 'required|numeric',
                    'rh_interne' => 'required',
                    'cout_externalisation' => 'required|numeric',
                ];
            }

            // Modification
            case 'PUT':
            {
                return [
                    'title' => 'required|max:255|unique:services,title,' . $this->service->id,
                    'slug' => 'unique:services,slug,' . $this->service->id,
                    'identifier' => 'required|numeric|unique:services,identifier,' . $this->service->id,
                    'availability_id' => 'required|exists:availabilities,id',
                    'category_id' => 'required|exists:categories,id',
                    'agent_responsable' => 'required|exists:users,id',
                    'agent_responsable_suppleant' => 'required|exists:users,id',
                    'autres_agents' => 'exists:users,id',
                    'delai_charge' => 'required|numeric',
                    'delai_oeuvre' => 'required|numeric',
                    'delai_tiers' => 'required|numeric',
                    'marge_securite' => 'required|numeric',
                    'rh_interne' => 'required',
                    'cout_externalisation' => 'required|numeric',
                ];
            }

            default:break;
        }
    }
}
