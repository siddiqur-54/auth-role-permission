<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(['name' => 'required']);
            Role::create($validated);
            return redirect()->route('admin.roles.index')->with('message', 'Role created successfully.');
        } 
        catch (RoleAlreadyExists $e) {
            return redirect()->back()->with('message', 'Role already exists. Please try a different name.');
        } 
        catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->back()->with('message', 'A similar role already exists. Please try a different name.');
            } else {
                return redirect()->back()->with('message', 'Database error occurred.');
            }
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        try {
            $validated = $request->validate(['name' => 'required']);
            $role->update($validated);
            return redirect()->route('admin.roles.index')->with('message', 'Role updated successfully.');
        } 
        catch (RoleAlreadyExists $e) {
            return redirect()->back()->with('message', 'Role already exists. Please try a different name.');
        } 
        catch (QueryException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->back()->with('message', 'A similar role already exists. Please try a different name.');
            } else {
                return redirect()->back()->with('message', 'Database error occurred.');
            }
        }
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return back()->with('message', 'Role deleted successfully.');
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission already exists.');
        }
        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added successfully.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked successfully.');
        }
        return back()->with('message', 'Permission not exists.');
    }
}
