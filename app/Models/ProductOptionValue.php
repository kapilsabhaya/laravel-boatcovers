<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOptionValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_option_value';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function optionValue() {
        return $this->belongsTo(OptionValue::class, 'option_value_id', 'id');
    }
    
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
