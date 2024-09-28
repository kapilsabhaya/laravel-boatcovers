<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'guest_user';
    protected $primaryKey = 'id';
    protected $guarded=[];
}
