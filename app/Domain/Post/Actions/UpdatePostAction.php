<?php

namespace App\Domain\Post\Actions;

use App\Domain\Post\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdatePostAction
{
    protected $saveStorageImages;

    public function __construct(SaveStorageImages $saveStorageImages)
    {
        $this->saveStorageImages = $saveStorageImages;
    }


    public function handle(
        UpdatePostRequest $request,
        Post $post,
    )
    {
        $allFilePaths = [];
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $data = $request->validated();
            $deleteAttachmentIds = $data['deleted_file_ids'] ?? [] ;
            $attachments = PostAttachment::query()
                ->where('post_id', $post->id)
                ->whereIn('id', $deleteAttachmentIds)->get();
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }
            $files = $data['attachments'] ?? [];
            $allFilePaths = $this->saveStorageImages->handle($files, $post, $user);
            $post->update($request->validated());
            DB::commit();
        }catch (\Exception $exception) {
            foreach ($allFilePaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw  $exception;
        }
    }
}
