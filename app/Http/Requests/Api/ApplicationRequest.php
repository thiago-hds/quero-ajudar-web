<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationRequest extends ApiFormRequest
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
        $user = Auth::user();

        return [
            'vacancy_id'        => 'required|exists:vacancies,id|unique:applications,vacancy_id,NULL,id,volunteer_user_id,' . $user->id,
            'volunteer_phone'   => 'required',
            'volunteer_message' => 'max:255'
        ];
    }
}
