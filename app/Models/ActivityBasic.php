<?php

namespace App\Models;

use Database\Factories\ActivityBasicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBasic extends Model
{
    use HasFactory;

    public static function newFactory(): ActivityBasicFactory
    {
        return ActivityBasicFactory::new();
    }

    public function activityType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function activityApplies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ActivityApply::class, 'activity_id');
    }
}
