<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'division_id'
    ];

    // relasi ke division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}