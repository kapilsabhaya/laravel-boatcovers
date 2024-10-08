<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFaq extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_faq';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
