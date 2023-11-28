<?php

namespace Modules\Category\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\app\Models\Product;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('categories')->singleFile();
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
