<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(){
        $depts = DB::table('departments')->orderBy('name', 'asc')->where('id','!=','1')->get();
        $sites = DB::table('sites')->orderBy('name', 'asc')->get();
        $users = User::with('site_row', 'department_row')->where('id', '!=', 1)->orderBy('name', 'asc')->get();

        // $users = DB::select('SELECT users.id, users.id_no, users.name, departments.name AS dept, sites.name AS site, users.email, users.phone FROM users INNER JOIN departments ON users.dept_id = departments.id INNER JOIN sites ON users.site = sites.id WHERE users.id != "1" ORDER BY users.name ASC');
        return view('admin.system-management.user', compact('users', 'depts', 'sites'));
    }

    public function edit(Request $request){
        $id = $request->id;

        $user = DB::table('users')->where('id', $id)->first();

        $result = array(
            "id_no"=>$user->id_no, 
            "name"=>$user->name, 
            "department"=>$user->dept_id, 
            "site"=>$user->site, 
            "role"=>$user->role, 
            "email"=>$user->email, 
            "phone"=>$user->phone
        );

        echo json_encode($result);
    }

    public function update(Request $request){
        if($request->password != null){
            $request->validate([
                'id_no' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'department' => ['required'],
                'site' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $role = $request->role;
            if($role == 'head'){
                $head = User::where('id', '!=', 1)->where('role', 'head')->first();
                if($head != null){
                    $head->role = 'user';
                    $head->save();
                }
            }

            $user = User::where('id', $request->id)->first();
            $user->id_no = strtoupper($request->id_no);
            $user->name = strtoupper($request->name);
            $user->dept_id = $request->department;
            $user->site = $request->site;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
        }else{
            $request->validate([
                'id_no' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'department' => ['required'],
                'site' => ['required'],
                'phone' => ['required', 'string', 'max:255'],
            ]);

            $role = $request->role;
            if($role == 'head'){
                $head = User::where('id', '!=', 1)->where('role', 'head')->first();
                if($head != null){
                    $head->role = 'user';
                    $head->save();
                }
            }

            $user = User::where('id', $request->id)->first();
            $user->id_no = strtoupper($request->id_no);
            $user->name = strtoupper($request->name);
            $user->dept_id = $request->department;
            $user->site = $request->site;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
        }

        return redirect()->route('user.index')->with('success', 'User details has been updated successfully');
    }

    public function delete(Request $request){
        DB::delete('delete from users where id = ?', [$request->id]);
        return redirect()->route('user.index')->with('success', 'User details has been deleted successfully');
    }

    public function changePass(){
        return view('change-pass');
    }

    public function updatePass(Request $request){

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::update('update users set password=?, first_time_login=0 where id = ?', [Hash::make($request->password), auth()->user()->id]);

        return redirect()->route('dashboard');
    }

    public function reset(Request $request){
        DB::table('users')
            ->where('id', $request->id)
            ->update([
                'password' => '$2y$10$EPxPbc./USkzSuIDCIvQl.4i43hoH1GPjE62Oxv3GpDrjon4Laj2O',
                'first_time_login' => 1
            ]);

        return redirect()->route('user.index')->with('success', 'Password Reset Successful! Default Password: ticketing2023');
    }
}