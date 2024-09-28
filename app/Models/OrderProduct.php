<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_product';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
