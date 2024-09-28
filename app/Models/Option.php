<?php

namespace App\Models;

use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'option';
    protected $primaryKey = 'id';
    protected $guarded=[];

    public function option(){
        return $this->hasMany(OptionValue::class,'option_id','id');
    }
}
