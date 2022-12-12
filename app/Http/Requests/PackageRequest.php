<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            $code = 'required|unique:packages,code,' . $id;
        } else {
            $code = 'required|unique:packages,code,NULL';
        }

        return [
            'code' => $code,
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'start_at' => 'required',
            'finish_at' => 'required|greater_than_field:start_at',
        ];
    }
}
