<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\Check;

class PermissionController extends Controller
{
    public function index()
    {
        Check::permission('Просмотр разрешений');
        $permissions = Permission::all();
        return view('pages.permission.index', compact('permissions'));
    }
}
