<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'master_category';
    protected $primaryKey = 'id';
    protected $guarded=[];

}
