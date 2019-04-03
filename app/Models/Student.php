<?php

namespace App\Models;

use App\User;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return explode(',', $this->skills);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
