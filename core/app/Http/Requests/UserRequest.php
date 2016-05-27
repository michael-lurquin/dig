<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\User;

class UserRequest extends Request
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
                    'name' => 'required|max:255',
                    'email' => $this->user()->can("manage_users") ? 'required|email|unique:users' : '',
                    'poste' => 'required',
                    'role_id' => $this->user()->can("manage_users") ? 'exists:roles,id' : '',
                    'password' => 'required|min:6|confirmed',
                ];
            }

            // Modification
            case 'PUT':
            {
                return [
                    'name' => 'required|max:255',
                    'email' => $this->user()->can("manage_users") ? 'required|email|unique:users,email,' . $this->user->id : '',
                    'poste' => 'required',
                    'role_id' => $this->user()->can("manage_users") ? 'exists:roles,id' : '',
                    'password' => !empty($this->password) ? 'required|min:6|confirmed' : '',
                ];
            }

            default:break;
        }
    }
}
