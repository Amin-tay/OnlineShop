<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DiscountCode\app\Models\DiscountCode;
use Modules\User\Database\factories\UserCodeFactory;

class UserCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

//    protected static function newFactory(): UserCodeFactory
//    {
//        //return UserCodeFactory::new();
//    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discountCode(){
        return $this->belongsTo(DiscountCode::class);
    }
}
