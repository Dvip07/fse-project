<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conflict extends Model
{
    use SoftDeletes;

    public $table = 'conflicts';
    protected $fillable = [
        'project_id',
        'prompt',
        'conflict_details',
        'conflict_resolution',
        'status',
        'user_id',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }   

}
