<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddress extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'order_address';
    protected $primaryKey = 'id';
    protected $guarded=[];
    
}
