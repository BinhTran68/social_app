<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        "id",
        "name",
        "slug",
        "cover_path",
        "thumbnail_path",
        "auto_approval",
        "about",
        "user_id",
        "deleted_at",
        "deleted_by",
        "created_at",
        "updated_at",
    ];
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')   // name
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }


}
