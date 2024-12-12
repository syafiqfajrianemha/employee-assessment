<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = ['id'];

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'assigns', 'program_id', 'user_id');
    }

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
