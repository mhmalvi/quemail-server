<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
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
            'files.*' => 'max:500|mimes:doc,docx,pdf,jpg,jpeg,png',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'subject' => 'required',
            'template' => 'required'
        ];
    }
}
