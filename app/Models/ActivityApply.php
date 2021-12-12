<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityApply extends Model
{
    use HasFactory;

    public function activityBasics() {
        return $this->belongsTo(ActivityBasic::class, 'activity_id', 'id');
    }

    // 這邊是往回找
    public function activityTypes() {
        // hasManyThrough 當本身與它表無關聯，可利用中繼表去查找(one to many)
        return $this->hasManyThrough(
            ActivityType::class, // 與中繼表關聯的表，跟自己沒有直接關聯
            ActivityBasic::class, // 中繼表
            'id', // 中繼表的外來鍵欄位(對應自己)
            'id', // 與中繼表關聯的表，跟中繼表對應用的外來鍵欄位(跟自己沒有直接關聯)
            'activity_id',
            'activity_type_id',
        );
    }

    // public function users() {
    //     return $this->hasMany(User::class);
    // }
}
