<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
