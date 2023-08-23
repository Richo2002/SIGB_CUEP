<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
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
        $id = Route::current()->parameter('resource');

        return [

            'identification_number' => ['nullable' ,'regex:/^\d{10}$|^\d{13}$/', Rule::unique('resources')->ignore($id ?? null)],
            'registration_number' => ['nullable', 'integer', 'regex:/^[0-9]+$/', Rule::unique('resources')->ignore($id ?? null)],
            'title' => ['required', 'string', 'max:150'],
            'cover_page' => ['image', 'max:3072', Rule::unique('resources')->ignore($id ?? null)],
            'digital_version' => ['nullable','file', 'mimes:pdf,mp4,mp3,zip'],
            'copies_number' => ['required', 'integer', 'regex:/^[0-9]+$/'],
            'page_number' => ['required', 'integer', 'regex:/^[0-9]+$/'],
            'keywords' => ['required', 'string', 'max:255'],
            'edition' => ['nullable', 'string', 'max:150'],
            'ray' => ['nullable', 'string', 'max:100'],
            'type_id' => ['required'],
            'category_id' => ['required'],
            'sub_category_id' => ['required'],
            'authors' => ['required', 'string', 'max:150'],
            'language' => ['required', 'string', Rule::in(['Francais', 'Anglais'])]
        ];
    }
}
