<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectDetailRequest extends FormRequest
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
        $rules = [];

        if($this->method() == 'POST') {
            $rules += [
                'moduleable_id'  => 'required',
                'start_end_date' => 'required',
            ];
        } elseif($this->method() == 'PUT') {
            $rules += [
                'start_end_date_actual' => 'required',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'This :attribute collumn is Required!',
        ];
    }
}
