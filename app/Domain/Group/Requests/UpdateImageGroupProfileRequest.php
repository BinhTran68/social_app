<?php

namespace App\Domain\Group\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class UpdateImageGroupProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $userId = Auth::id();
        $group = request()->route('group');
        return $userId == $group->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'string',
            'file' => [
                File::types(['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp3',
                    'wav', 'mp4', 'doc', 'docx', 'pdf', 'csv', 'xls', 'xlsx', 'zip'
                ])->max(500 * 1024 * 1024)],
        ];
    }
}
