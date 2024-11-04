<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stakeholders extends Model
{ 
    use SoftDeletes;

    public $table = 'stakeholders';
    protected $fillable = [
        'projects_id',
        'user_id',
        'role',
    ];

    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Projects::class, 'projects_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
