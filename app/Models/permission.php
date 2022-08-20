<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;

    public $fillable=[
        'permission_name',
        'details',
        'menu_name',
        'route_name',
        'status',
        'parent_id',
        'group_name',
        'is_menu',
        'serial',
    ];
}