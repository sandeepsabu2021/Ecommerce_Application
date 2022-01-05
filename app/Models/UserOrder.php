<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOrder extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "user_orders";
    
    public function details(){
        return $this->hasMany(OrderDetail::class);
    }
}
