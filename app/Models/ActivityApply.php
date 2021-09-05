<?php

namespace App\Models;

use App\Models\User;
use App\Models\ActivityBasic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityApply extends Model
{
    use HasFactory;

    public function activityBasics() {
        return $this->belongsTo(ActivityBasic::class, 'activity_id', 'id');
    }

    // public function users() {
    //     return $this->hasMany(User::class);
    // }
}
