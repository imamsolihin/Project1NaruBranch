<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'division_id',
        'deadline',
        'user_id'
    ];

    // relasi ke division
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // relasi ke user (pembuat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}