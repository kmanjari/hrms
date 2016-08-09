<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;

class RoleController extends Controller
{
    public function addRole()
    {
        return view('hrms.role.add_role');
    }

    Public function processRole(Request $request)
    {
        //Role::create(['name' => $request->name, 'description' => $request->description]);
        $role = new Role;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        \Session::flash('flash_message', 'Role successfully added!');
        return redirect()->back();

    }

    public function showRole()
    {
        $roles = Role::paginate(10);
        return view('hrms.role.show_role', compact('roles'));
    }

    public function showEdit($id)
    {
        $result = Role::whereid($id)->first();
        return view('hrms.role.add_role', compact('result'));
    }

    public function doEdit(Request $request, $id)
    {
        $name = $request->name;
        $description = $request->description;

        $edit = Role::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();
        \Session::flash('flash_message', 'Role successfully updated!');
        return redirect('role-list');
    }

    public function doDelete($id)
    {
        $role = Role::find($id);
        $role->delete();
        \Session::flash('flash_message', 'Role successfully Deleted!');
        return redirect('role-list');
    }

}
