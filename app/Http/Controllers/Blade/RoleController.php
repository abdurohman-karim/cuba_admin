<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Services\Check;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);

        return view('pages.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('pages.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            foreach ($request->permissions as $item) {
                $role->givePermissionTo($item);
            }
        }

        message_set('Роль создана успешно', 'success');
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        Check::permission('Редактировать роли');

        $role = Role::with('permissions')->where('id', $id)->first();
        $permissions = Permission::all();
        return view('pages.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        Check::permission('Редактировать роли');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::where('id', $id)
            ->where('id', '!=', auth()->user()->id)
            ->first();

        if (!$role) {
            message_set('Роль не найдена', 'error');
            return redirect()->route('roles.index');
        }

        if ($role->name === 'Super Admin') {
            message_set('Нельзя редактировать роль Super Admin', 'error');
            return redirect()->route('roles.index');
        }

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->detach();
            foreach ($request->permissions as $item) {
                $role->givePermissionTo($item);
            }
        }

        message_set('Роль обновлена успешно', 'success');
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        Check::permission('Удаление роли');

        $role = Role::where('id', $id)
            ->where('id', '!=', auth()->user()->id)
            ->first();

        if (!$role) {
            message_set('Роль не найдена', 'error');
            return redirect()->route('roles.index');
        }

        if ($role->name === 'Super Admin') {
            message_set('Нельзя удалить роль Super Admin', 'error');
            return redirect()->route('roles.index');
        }

        $role->permissions()->detach();
        $role->delete();

        message_set('Роль удалена успешно', 'success');
        return redirect()->route('roles.index');
    }
}
