<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;


class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(['name' => 'required']);
            Permission::create($validated);
            return to_route('admin.permissions.index')->with('message', 'Permission created successfully.');
        }
        catch (PermissionAlreadyExists $e) {
            return redirect()->back()->with('message', 'Permission already exists. Please try a different name.');
        }
        catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->back()->with('message', 'A similar permission already exists. Please try a different name.');
            } else {
                return redirect()->back()->with('message', 'Database error occurred.');
            }
        }
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        try {
            $validated = $request->validate(['name' => 'required']);
            $permission->update($validated);
            return to_route('admin.permissions.index')->with('message', 'Permission updated successfully.');
        }
        catch (PermissionAlreadyExists $e) {
            return redirect()->back()->with('message', 'Permission already exists. Please try a different name.');
        }
        catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->back()->with('message', 'A similar permission already exists. Please try a different name.');
            } else {
                return redirect()->back()->with('message', 'Database error occurred.');
            }
        }
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('message', 'Permission deleted successfully.');
    }

    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role already exists.');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role assigned successfully.');
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed successfully.');
        }

        return back()->with('message', 'Role not exists.');
    }
}
