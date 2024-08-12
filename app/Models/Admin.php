<?php

namespace App\Models;

use App\Concerns\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//لازم تعمل استعاء لليوزر بدل من المموديل
class Admin extends User
{
    use HasFactory,Notifiable, HasApiTokens,HasRoles;
    //عرفه في config auth
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'super_admin', 'status',
    ];

    // public function roles()
    // {
    //     return $this->morphToMany(Role::class, 'authorizable', 'role_user');
    // }
}
