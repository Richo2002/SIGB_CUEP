<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
        return [
            'end_date' => ['required', 'date', 'after_or_equal:'.now()->addDays(5)->toDateString()],
            'npi' => ['required_without:group_id', 'regex:/^\d{10}$/'],
            'group_id' => ['required_without:npi'],
        ];
    }
}
