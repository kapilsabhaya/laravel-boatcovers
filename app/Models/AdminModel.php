<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModel extends Authenticatable
{
    use HasFactory,HasRoles;
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $guarded=[];
    public $timestamps = false ;
}
