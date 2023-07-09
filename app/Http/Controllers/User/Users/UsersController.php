<?php

namespace App\Http\Controllers\User\Users;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        return view('user.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
}
