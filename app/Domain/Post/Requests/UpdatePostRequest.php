<?php

namespace App\Domain\Post\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;


class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //  Todo maybe change latter
        $post = Post::where('id', $this->input('id'))->where('user_id', Auth::id())->first();
        return !!$post;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable'],
            'attachments' => 'array|max:10' ,
            'attachments.*' => [
                File::types(['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp3',
                    'wav', 'mp4', 'doc', 'docx', 'pdf', 'csv', 'xls', 'xlsx', 'zip'
                ])->max(500 * 1024 * 1024)
            ],
            'user_id' => ['numeric']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => auth()->user()->id]);
    }
}
