<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Make extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'make';
    protected $primaryKey = 'id';
    protected $guarded=[];

}
