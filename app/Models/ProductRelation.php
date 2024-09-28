<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRelation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_relation';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
