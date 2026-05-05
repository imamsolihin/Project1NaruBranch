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
        'user_id',
        'assigned_user_id'
    ];

    // relasi ke division (many-to-many)
    public function divisions()
    {
        return $this->belongsToMany(Division::class);
    }

    // relasi ke user (pembuat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke user (penerima tugas - many-to-many)
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }
}