<?php

namespace App\Domain\Post\Actions;

use App\Models\Post;
use App\Models\PostAttachment;

class SaveStorageImages
{
    public function handle($files, Post $post, $user)
    {
        $allFilePaths = [];
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
        return $allFilePaths;
    }
}
