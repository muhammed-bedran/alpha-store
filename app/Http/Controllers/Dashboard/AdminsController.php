<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Melbedran\RolePermession\Models\Role;

class AdminsController extends Controller
{
    //
    public function index()
    {
        
        return view('dashboard.pages.admins.index',[
            'admins'=>Admin::all()
        ]);
    }
    protected function roles()
    {
        return Role::query()->orderBy('name')->get();
    }
    public function create()
    {
        return view('dashboard.pages.admins.create',[
            'roles'=>$this->roles(),
            'admin'=>new Admin,
        ]);
    }  
    protected   function validated(Request $request, ?Admin $admin = null)
    {
        $rolesTable= Config::get('role-permession.tables.roles','roles');
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => [
                $admin ? 'nullable' : 'required',
                'confirmed',
                Password::defaults(),
            ],
           'roles' =>['nullable', 'array'],
           'roles.*' =>['required', 'exists:'.$rolesTable.',id'],
        ]);
    } 
    public function store(Request $request)
    {
     $data = $this->validated($request);
     $roleIds = $data['roles'] ?? [];
     unset($data['roles']);
     $data['super_admin'] = $request->boolean('super_admin');
     if($data['password']){
        $data['password'] = bcrypt($data['password']);
     }
     $admin = Admin::create($data);
     $admin->roles()->sync($roleIds);
     return redirect()->route('dashboard.admins.index');
    } 
    public function edit(Admin $admin)
    {
        return view('dashboard.pages.admins.edit',[
            'admin'=>$admin,
            'roles'=>$this->roles(),
        ]);
    }
    public function update(Request $request, Admin $admin)
    {
        $data = $this->validated($request,$admin);
        $roleIds = $data['roles'];
        unset($data['roles']);
        $data['super_admin'] = $request->boolean('super_admin');
        if(empty($data['password'])){
            unset($data['password']);
        }
        $admin->update($data);
        $admin->roles()->sync($roleIds);
        return redirect()->route('dashboard.admins.index');
    }
    public function destroy(Admin $admin)
    {
        if($admin->id === Auth::guard('admin')->id()){
            return redirect()->route('dashboard.admins.index')->with('error','You cannot delete yourself');
        }
        $admin->delete();
        return redirect()->route('dashboard.admins.index');
    }
}
