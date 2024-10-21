<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'user_id',
    ];
    use HasFactory;
}
