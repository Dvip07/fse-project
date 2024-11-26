<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AIResponse extends Model
{
    use SoftDeletes;

    public $table = 'ai_response';

    protected $fillable = [
        'project_id',
        'prompt',
        'response',
        'assigned_role',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
    
    // public function stakeholder()
    // {
    //     return $this->belongsTo(Stakeholders::class, 'assigned_role'); 
    // }
    
}
