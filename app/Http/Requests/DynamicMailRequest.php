<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DynamicMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'driver'=>'required',
            'host'=>'required',
            'port'=>'required',
            'username'=>'required|email',
            'password'=>'required',
            'encryption'=>'required',
            'from_mail_address'=> 'required|email',
            'from_name'=>'required',
            'user_id'=>'required'
        ];
    }
}
