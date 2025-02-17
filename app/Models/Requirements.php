<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirements extends Model
{
    use SoftDeletes;

    public $table = 'requirements';

    protected $fillable = [
        'project_id',
        'title',
        'desc',
        'priority',
        'status',
        'created_by',
    ];

    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholders::class, 'project_id', 'project_id');
    }
}
