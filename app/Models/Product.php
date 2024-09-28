<?php

namespace App\Models;

use App\Models\Setting;
use App\Models\Category;
use App\Models\ProductMedia;
use App\Models\ProductOptionValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function getCategory() {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function media(){
        return $this->hasMany(ProductMedia::class,'product_id','id');
    }

    public function productOption() {
        return $this->hasMany(ProductOptionValue::class,'product_id','id');
    }

    public function setting() {
        return $this->hasMany(Setting::class,'product_id','id');
    }
}

