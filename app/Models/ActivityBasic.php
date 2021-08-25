<?php

namespace App\Models;

use App\Models\User;
use App\Models\ActivityType;
use App\Models\ActivityApply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityBasic extends Model
{
    use HasFactory;

    public static function newFactory()
    {
        return \Database\Factories\ActivityBasicFactory::new();
    }

    public function activityType() {
        return $this->belongsTo(ActivityType::class);
    }

    public function activityApplies() {
        return $this->hasMany(ActivityApply::class, 'activity_id');
    }
}
