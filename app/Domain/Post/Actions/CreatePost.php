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
            foreach ($files as $file) {
                $path = $file->store('attachments/'.$post->id, 'public');
                $allFilePaths[] = $path;
                PostAttachment::create([
                    'post_id' => $post->id,
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => $user->id
                ]);
            }
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
