<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public $menu;
    
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    view()->composer('layouts.app', function ($view) 
    {
        if (isset(Auth::user()->role_id)) {
            $role_id=Auth::user()->role_id;
        $permissions=Role::find($role_id)->permission_name;
        if (!empty($permissions)) {
            $menu_permission=explode(',',$permissions);
        
            $get_permission=permission::whereIn('permission_name',$menu_permission)->where(['is_menu'=>'yes','status'=>7]) ->orderBy('serial', 'asc')->get();

            foreach ($get_permission as $key => $value) {
                if ($value->parent_id==0) {
                    $sub_menu_list=permission::whereIn('permission_name',$menu_permission)->where('parent_id',$value->id)->get();

                    if ($sub_menu_list->count()) {
                        foreach ($sub_menu_list as $smk => $smv) {
                            $sub_menu_II=permission::whereIn('permission_name',$menu_permission)->where('parent_id',$smv->id)->get();
                            if ($sub_menu_II->count()) {
                                foreach ($sub_menu_II as $smkII => $smvII) {
                                    $sub_menu_III=permission::whereIn('permission_name',$menu_permission)->where('parent_id',$smvII->id)->get();
                                    if ($sub_menu_III->count()) {
                                        $sub_menu_II[$smkII]->{'sub_menu_III'}=$sub_menu_III;
                                    }
                                }
                                $sub_menu_list[$smk]->{'sub_menu_II'}=$sub_menu_II;
                            }
                        }
                        $value->{'sub_menu'}=$sub_menu_list;
                    }
                    $this->menu[$key]=$value;
                }
            }
        }
        
        }
        
        $view->with(['menu' => $this->menu]);    
    }); 
        
    }
}