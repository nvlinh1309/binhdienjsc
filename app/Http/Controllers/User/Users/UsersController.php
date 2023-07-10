<?php

namespace App\Http\Controllers\User\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::with('roles')->orderBy('id', 'DESC');
        if (isset($request->search)) {
            $search = $request->search;
            $columns = ['name', 'email'];
            $data->where(function ($subQuery) use ($columns, $search){
                foreach ($columns as $column) {
                  $subQuery = $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                }
                return $subQuery;
              });
        }
        $data = $data->paginate(5);
        return view('user.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('user.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with('roles')->find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.user.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::get();
        $data = User::find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.user.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if (!$data) {
            abort(404);
        }
        $data->assignRole($request->role);
        $data->update($request->all());
        return redirect()->route('users.show',$id)->with(['success' => 'Thông tin người dùng '.$data->name.' đã được cập nhật!!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function indexRaP()
    {
        // $roles = [
        //     [

        //     ]
        //     ];
        // $role = Role::create([
        //     'name' => 'Quản trị',
        //     'display_name' => 'admin'
        // ]);

        // $permissions = ['access', 'create', 'update', 'delete'];
        // foreach ($permissions as $key => $value) {
        //     $permission = Permission::create(
        //         ['name' => $value]);
        //     $permission->assignRole($role);
        // }


        $data = Role::with('permissions')->paginate(10);

        return view('user.user.roleandpermission.index', compact('data'));
    }

    public function showRaP($id)
    {
        $data = Role::with('permissions')->find($id);
        if (!$data) {
            abort(404);
        }
        return view('user.user.roleandpermission.show', compact('data'));
    }

    public function storeRaP(Request $request)
    {

    }


    public function exportPDF()
    {
        return "Tính năng đang phát triển";
    }
}
