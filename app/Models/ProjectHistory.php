<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHistory extends Model
{
    protected $fillable = ['actor_id', 'project_id', 'action', 'project_title', 'description'];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
