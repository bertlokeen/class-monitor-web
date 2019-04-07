<?php

namespace App\Models;

use App\Models\ActiviyScore;
use App\Models\SectionClass;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function sectionClass()
    {
        return $this->belongsTo(SectionClass::class);
    }

    public function scores()
    {
        return $this->hasMany(ActivityScore::class);
    }
}
