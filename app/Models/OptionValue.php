<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionValue extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'option_value';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function option(){
        return $this->belongsTo(Option::class,'option_id','id');
    }
}
