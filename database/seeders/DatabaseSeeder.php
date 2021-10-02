<?php

namespace Database\Seeders;

use App\Models\ActivityApply;
use App\Models\ActivityBasic;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10)->create();

        // ActivityType::factory(2)->has(User::factory()->count(1))->create();
        // ActivityType::factory()
        //     ->has(ActivityBasic::factory()->count(3))
        //     ->create();
//        ActivityType::factory(3)->has(
//            ActivityBasic::factory(3)->has(ActivityApply::factory(5))
//        )->create();

        // ActivityBasic::factory(30)->for(ActivityType::factory())->create();
        // ActivityType::newFactory(2)->has(ActivityBasic::factory(3))->create();


        // 建立 ActivityAdmin 角色
        $role = Role::create(['guard_name' => 'api', 'name' => 'ActivityAdmin']);

        // 取得 admin User
        $user = User::where('u_no', '=', 'admin')->first();

        $user->assignRole($role);

        Permission::create(['guard_name' => 'api', 'name' => 'S01110_access']);
        Permission::create(['guard_name' => 'api', 'name' => 'S01110_new']);
        Permission::create(['guard_name' => 'api', 'name' => 'S01110_edit']);
        Permission::create(['guard_name' => 'api', 'name' => 'S01110_del']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01110_access']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01110_new']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01110_edit']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01110_del']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01120_access']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01120_new']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01120_edit']);
        Permission::create(['guard_name' => 'api', 'name' => 'A01120_del']);
        $permission = Permission::where('name', 'like', 'A01%')->orWhere('name', 'like', 'S01%')->get();

        /*******/

        // 建立 User 角色
        $role = Role::create(['guard_name' => 'api', 'name' => 'User']);
        $role->givePermissionTo($permission);

        // 取得 User
        $user = User::where('u_no', '=', 'alex123654')->first();

        // 授權給user
        $user->assignRole($role);

    }
}
