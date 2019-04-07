<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Admin;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\Faculty;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard_name = 'web';

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function fullname()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function announcementIds()
    {
        return $this->announcements->pluck('id')->toArray();
    }
}
