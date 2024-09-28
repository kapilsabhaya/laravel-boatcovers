<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductMedia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_media';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
