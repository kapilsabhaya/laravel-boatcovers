<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Year extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'year';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
