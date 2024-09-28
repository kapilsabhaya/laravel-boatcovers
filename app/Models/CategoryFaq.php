<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryFaq extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category_faq';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
