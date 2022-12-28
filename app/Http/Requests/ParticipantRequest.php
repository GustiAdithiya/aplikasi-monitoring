<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
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
        $id = $this->get('id');
        if ($this->method() == 'PUT') {
            $photo = 'image|mimes:jpeg,png,jpg,gif|max:4096';
            $no_identity = 'required|numeric|unique:participants,no_identity,' . $id;
        } else {
            $photo = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
            $no_identity = 'required|numeric|unique:participants,no_identity,NULL';
        }
        return [
            'name' => 'required|string|max:255',
            'no_identity' => $no_identity,
            'photo' => $photo
        ];
    }
}
