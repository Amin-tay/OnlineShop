<?php

namespace Modules\Category\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\app\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use SoftDeletes;


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('categories')->singleFile();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'deleted_at'])
            ->dontLogIfAttributesChangedOnly(['deleted_at'])
            ->logOnlyDirty();
    }
}
