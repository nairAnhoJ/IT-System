<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        $depts = DB::table('departments')->orderBy('name', 'asc')->get();
        return view('admin.system-management.department', compact('depts'));
    }

    public function add(Request $request){
        $dept_name = strtoupper($request->name);

        $request->validate([
            'name' => 'required',
        ]);

        $dept = new Department();
        $dept->name = $dept_name;
        $dept->save();

        $depts = DB::table('departments')->orderBy('name', 'asc')->get();
        return view('admin.system-management.department', compact('depts'));
    }

    public function edit(Request $request){
        $dept_id = $request->id;
        $dept_name = strtoupper($request->name);

        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        DB::update('update departments set name = ? where id = ?', [$dept_name, $dept_id]);

        return redirect()->route('department.index');
    }

    public function delete(Request $request){
        $dept_id = $request->id;

        DB::delete('delete FROM departments where id = ?', [$dept_id]);

        return redirect()->route('department.index');
    }
}
