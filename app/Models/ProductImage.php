<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = "product_images";
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
