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
                    'availability_id' => 'required|exists:availability,id',
                ];
            }

            // Modification
            case 'PUT':
            {
                return [
                    'title' => 'required|max:255|unique:services,title,' . $this->service->id,
                    'slug' => 'unique:services,slug,' . $this->service->id,
                    'identifier' => 'required|numeric|unique:services,identifier,' . $this->service->id,
                    'availability_id' => 'required|exists:availability,id',
                ];
            }

            default:break;
        }
    }
}
