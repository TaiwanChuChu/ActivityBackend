<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuCollection;
use App\Models\SysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SysMenu $sysMenu
     * @return \Illuminate\Http\Response
     */
    public function show(SysMenu $sysMenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SysMenu $sysMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SysMenu $sysMenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SysMenu $sysMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(SysMenu $sysMenu)
    {
        //
    }

    /**
     * 使用該使用者之角色(role)取得對應的選單資料
     *
     * @return MenuCollection
     */
    public function getMenuListByUser()
    {
        $RoleId = auth()->user()->roles->pluck('id')->toArray();

        return new MenuCollection(
            SysMenu::from('sys_menus as a')->with([
                'children' => function ($query) use ($RoleId) {
                    $query->from('sys_menus')
                        ->whereExists(function ($query) use ($RoleId) {
                            $query->select(DB::raw(1))
                                ->from('role_has_menus')
                                ->whereColumn('sys_menus.id', 'role_has_menus.sys_menu_id')
                                ->whereIn('role_has_menus.role_id', $RoleId);
                        });
                }
            ])->whereExists(function ($query) use ($RoleId) {
                $query->from('sys_menus as b')
                    ->whereColumn('a.id', 'b.upper_id')
                    ->whereExists(function ($query) use ($RoleId) {
                        $query->select(DB::raw(1))
                            ->from('role_has_menus')
                            ->whereColumn('b.id', 'role_has_menus.sys_menu_id')
                            ->whereIn('role_has_menus.role_id', $RoleId);
                    });
            })->get()
        );
    }
}
