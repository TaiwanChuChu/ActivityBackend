<?php

namespace App\Models;

use Database\Factories\ActivityBasicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityBasic extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'activity_type_id',
        'theme',
        'description',
        'place',
        'apply_limit',
        'apply_sdate',
        'apply_edate',
        'apply_state',
        'sdate',
        'edate',
    ];

    protected $casts = [
        'apply_state' => 'bool'
    ];

    public static function newFactory(): ActivityBasicFactory
    {
        return ActivityBasicFactory::new();
    }

    // 活動類別 one to many 活動基本資料
    public function activityType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ActivityType::class);
    }

    // 活動申請 many to one 活動基本資料
    public function activityApplies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ActivityApply::class, 'activity_id');
    }
}
