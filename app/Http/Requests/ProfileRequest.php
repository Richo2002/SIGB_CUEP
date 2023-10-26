<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $id = Route::current()->parameter('profile');
        return [
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:50'],
            'npi' => ['required', 'regex:/^\d{10}$/', Rule::unique('users')->ignore($id ?? null)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id ?? null)],
            'phone_number' => ['required', 'regex:/^\d{8}$/'],
            'address' => ['nullable', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:2048'],
            // 'role' => ['required', Rule::in(['Bibliothécaire', 'Administrateur', 'Etudiant', 'Professeur', 'Personnel', 'Autre'])],
        ];
    }
}
