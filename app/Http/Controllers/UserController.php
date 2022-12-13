<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $depts = DB::table('departments')->orderBy('name', 'asc')->get();
        $users = DB::select('SELECT users.id, users.id_no, users.name, departments.name AS dept, users.phone FROM users INNER JOIN departments ON users.dept_id = departments.id WHERE users.id != "1" ORDER BY users.name ASC');
        return view('admin.system-management.user', compact('users', 'depts'));
    }

    public function edit(Request $request){
        if($request->password != ''){
            $request->validate([
                'id_no' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'name' => ['required', 'string', 'max:255'],
                'department' => ['required'],
                'phone' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

        }else{
            $request->validate([
                'id_no' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'name' => ['required', 'string', 'max:255'],
                'department' => ['required'],
                'phone' => ['required', 'string', 'max:255'],
            ]);
        }

    }
}
