<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = ['actor_id', 'action', 'target_name', 'description'];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
