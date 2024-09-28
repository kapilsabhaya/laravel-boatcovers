<?php

namespace App\Models;

use App\Models\MasterCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function category() {
        return $this->belongsTo(MasterCategory::class,'master_category_id','id');
    }

}
