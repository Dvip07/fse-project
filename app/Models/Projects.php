<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'milestone',
        'non_functional_req',
        'additional_instruction',
        'domain',
        'dev_methods',
        'tech_stack',
        'survey_methods',
        'user_id',
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function stakeholders()
    {
        return $this->hasMany(Stakeholders::class);
    }

    public function ai_response()
    {
        return $this->hasMany(AIResponse::class);
    }
}
