<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class InstituteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role == "Administrateur";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Route::current()->parameter('institute');

        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('institutes')->ignore($id ?? null)],
            'address' => ['required', 'string', 'max:150'],
            'librarian_id' => ['required'],
        ];
    }
}
