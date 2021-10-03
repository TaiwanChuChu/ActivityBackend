<?php

namespace Database\Seeders;

use App\Models\RoleHasMenu;
use App\Models\SysMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class SysMenuAndGrantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_menu = [
            'S01' => [
                function ($upper_id) {
                    return ['p_no' => 'S01110', 'p_name' => 'S01110_選單', 'status' => '1', 'upper_id' => $upper_id];
                }
            ],
            'A01' => [
                function ($upper_id) {
                    return ['p_no' => 'A01110', 'p_name' => '活動類別維護', 'status' => '1', 'upper_id' => $upper_id];
                },
                function ($upper_id) {
                    return ['p_no' => 'A01120', 'p_name' => '活動資料維護', 'status' => '1', 'upper_id' => $upper_id];
                },
                function ($upper_id) {
                    return ['p_no' => 'A01130', 'p_name' => '活動報名維護', 'status' => '1', 'upper_id' => $upper_id];
                }
            ],
            'P01' => [
                function ($upper_id) {
                    return ['p_no' => 'P01110', 'p_name' => '基本資料維護', 'status' => '1', 'upper_id' => $upper_id];
                },
            ],
            'F01' => [
                function ($upper_id) {
                    return ['p_no' => 'F01110', 'p_name' => '尚可報名活動', 'status' => '1', 'upper_id' => $upper_id];
                },
                function ($upper_id) {
                    return ['p_no' => 'F01120', 'p_name' => '已報名活動', 'status' => '1', 'upper_id' => $upper_id];
                },
            ]
        ];
        foreach ([
                     'S01' => ['p_no' => 'S01', 'p_name' => '系統模組', 'status' => '1'],
                     'A01' => ['p_no' => 'A01', 'p_name' => '活動管理', 'status' => '1'],
                     'P01' => ['p_no' => 'P01', 'p_name' => '個人管理', 'status' => '1'],
                     'F01' => ['p_no' => 'F01', 'p_name' => '活動前台', 'status' => '1'],
                 ] as $p_id => $items
        ) {
            $source = SysMenu::create($items);
            foreach ($sub_menu[$p_id] as $sub_item) {
                SysMenu::create($sub_item($source->id));
            }
        }

        $RoleActivityAdminId = Role::findByName('ActivityAdmin', 'api')->id;
        $SysMenuIds = SysMenu::whereNotNull('upper_id')->get()->toArray();
        foreach ($SysMenuIds as $item) {
            RoleHasMenu::create(['role_id' => $RoleActivityAdminId, 'sys_menu_id' => $item['id']]);
        }

        $RoleActivityUserId = Role::findByName('User', 'api')->id;
        $SysMenuIds = SysMenu::whereIn('p_no', ['P01110', 'F01110', 'F01120'])->get()->toArray();
        foreach ($SysMenuIds as $item) {
            RoleHasMenu::create(['role_id' => $RoleActivityUserId, 'sys_menu_id' => $item['id']]);
        }
    }
}
