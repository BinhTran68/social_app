<?php

namespace App\Domain\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'body' => ['nullable','max:5'],
            'attachments' =>
                'array|max:2',
                function ($attribute, $value, $fail) {
                    $totalSize = collect($value)->sum(function (UploadedFile $file){
                       return $file->getSize();
                    });
                    if ($totalSize > 1000000) {
                        $fail('The total size of all files must not exceed 1GB.');
                    }
                },
            'attachments.*' => [
                File::types(['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp3',
                    'wav', 'mp4', 'doc', 'docx', 'pdf', 'csv', 'xls', 'xlsx', 'zip'
                ])->max(500 * 1024 * 1024)],
            'user_id' => ['numeric']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => auth()->user()->id]);
    }
}
