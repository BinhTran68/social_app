<?php

namespace App\Domain\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ];
    }
}
