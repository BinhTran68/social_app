<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreatePost
{

    protected $saveStorageImages;

    public function __construct(SaveStorageImages $saveStorageImages)
    {
        $this->saveStorageImages = $saveStorageImages;
    }

    public function handle(StorePostRequest $request)
    {
        $allFilePaths = [];
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $data = $request->validated();
            $post = Post::create($data);
            /** @var UploadedFile $file */
            $files = $data['attachments'] ?? [];
            $allFilePaths = $this->saveStorageImages->handle($files, $post, $user);
            DB::commit();
            return back();
        } catch (\Exception $e) {
            foreach ($allFilePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw  $e;
        }

    }
}
