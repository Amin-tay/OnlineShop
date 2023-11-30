<?php

namespace Modules\DiscountCode\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    public function userCode(){
        return $this->hasMany(UserCode::class);
    }
}
