<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
