<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstanceRequest extends FormRequest
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
        $uid = $this->get('user_id');
        if ($this->method() == 'PUT') {
            $email = 'required|unique:instances,email,' . $id;
            $phone = 'required|unique:instances,phone,' . $id;
            $username = 'required|unique:users,username,' . $uid;
            $password = 'nullable|string|min:8|confirmed';
            $photo = 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096';
        } else {
            $email = 'required|unique:instances,email,NULL';
            $phone = 'required|unique:instances,phone,NULL';
            $photo = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
            $username = 'required|unique:users,username,NULL';
            $password = 'required|string|min:8|confirmed';
        }
        return [
            'name' => 'required|string|max:255',
            'instance_name' => 'required|string|max:255',
            'instance_address' => 'required|string',
            'email' => $email,
            'phone' => $phone,
            'photo' => $photo,
            'username' => $username,
            'password' => $password,
        ];
    }
}
