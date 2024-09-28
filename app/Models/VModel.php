<?php

namespace App\Models;

use App\Models\Make;
use App\Models\Category;
use App\Models\VehicleVeriant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'model';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function make() {
        return $this->belongsTo(Make::class,'make_id','id');
    }
}
