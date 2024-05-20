<?php

namespace App\Domain\Post\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;


class UpdatePostRequest extends StorePostRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //  Todo maybe change latter
        $post = Post::query()
            ->where('id', $this->input('id'))
            ->where('user_id', Auth::id())
            ->first();
        return !!$post;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return array_merge(parent::rules(), [
           'deleted_file_ids' => ['array'],
           'deleted_file_ids.*' => ['numeric']
       ]);
    }
    protected function prepareForValidation()
    {
        $this->merge(['user_id' => auth()->user()->id]);
    }
}
