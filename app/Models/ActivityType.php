<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id', 'type_code', 'type_name', 'state', 'CreateID'
    ];

    // 使用狀態 state
    const STATE_ENABLE = true;
    const STATE_DISABLE = false;

    protected $casts = [
        'state' => 'boolean',
    ];

    public static function newFactory()
    {
        return \Database\Factories\ActivityTypeFactory::new();
    }

    public function activityBasic()
    {
        return $this->hasMany(ActivityBasic::class, 'activity_type_id');
    }

    public function activityApplies()
    {
        // hasManyThrough 當本身與它表無關聯，可利用中繼表去查找(one to many)
        return $this->hasManyThrough(
            ActivityApply::class, // 與中繼表關聯的表，跟自己沒有直接關聯
            ActivityBasic::class, // 中繼表
            'activity_type_id', // 中繼表的外來鍵欄位(對應自己)
            'activity_id', // 與中繼表關聯的表，跟中繼表對應用的外來鍵欄位(跟自己沒有直接關聯)
        );
    }

    public function scopeEnable($query)
    {
        return $query->where('state', '=', self::STATE_ENABLE);
    }

    public function scopeDisable($query)
    {
        return $query->where('state', '=', self::STATE_DISABLE);
    }
}
