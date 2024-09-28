<?php

namespace App\Models;

use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $guarded=[];
    
    public function order_product() {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function order_address() {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id');
    }
}
