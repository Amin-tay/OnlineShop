<?php

namespace Modules\DiscountCode\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\app\Models\User;
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
