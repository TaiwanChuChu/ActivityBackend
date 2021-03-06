<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function activityApplies() {
    //     return $this->belongsToMany(ActivityApply::class);
    // }

    /**
     * Find the user instance for the given username.
     *
     * @param string $username
     * @return \App\Models\User
     */
    public function findForPassport(string $username)
    {
        return $this->where('u_no', $username)->first();
    }

    public function file_storages() {
        return $this->morphMany(FileStorage::class, 'file_storage');
    }
}
