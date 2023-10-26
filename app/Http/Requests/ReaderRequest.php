<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ReaderRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role == "Bibliothécaire";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Route::current()->parameter('reader');

        return [
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:25'],
            'npi' => ['nullable', 'regex:/^\d{10}$/', Rule::unique('users')->ignore($id ?? null)],
            'registration_number' => ['required', 'regex:/^[a-zA-Z0-9]{12}$/', Rule::unique('users')->ignore($id ?? null)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id ?? null)],
            'phone_number' => ['required', 'regex:/^\d{8}$/'],
            'address' => ['required', 'string', 'max:100'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'role' => ['required', Rule::in(['Etudiant', 'Professeur', 'Personnel', 'Autre'])],
        ];
    }
}
