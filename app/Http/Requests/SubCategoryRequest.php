<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
        $id = Route::current()->parameter('sub-categorie');

        return [
            'name' => ['required', 'string', 'max:150', Rule::unique('sub_categories')->ignore($id ?? null)],
            'classification_number' => ['required', 'regex:/^[0-9]+$/', Rule::unique('sub_categories')->ignore($id ?? null)],
            'category_id' => ['required'],
        ];
    }
}
