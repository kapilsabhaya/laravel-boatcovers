<?php

namespace App\Models;

use App\Models\Year;
use App\Models\VModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleVeriant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'vehicle_variant';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function year(){
        return $this->belongsTo(Year::class,'year_id','id');
    }
    public function model(){
        return $this->belongsTo(VModel::class,'model_id','id');
    }
    
}
