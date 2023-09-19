<?php

namespace App\Http\Controllers\User\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Users\StoreUserRequest;
use App\Http\Requests\User\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Mail;
use App\Mail\CreateAccount;
use App\Models\User\ParentPermission;
use Illuminate\Support\Facades\Mail as FacadesMail;
use DB;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-view')->only('index');
        $this->middleware('permission:user-create')->only('create', 'store');
        $this->middleware('permission:user-view')->only('view', 'show');
        $this->middleware('permission:user-edit')->only('edit', 'update');
        $this->middleware('permission:user-delete')->only('destroy');
    }
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
            $data->where(function ($subQuery) use ($columns, $search) {
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
    public function store(StoreUserRequest $request)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $password = Str::random(10);
            $request['password'] = Hash::make($password);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password
            ];
            new CreateAccount($data);
            // Mail::to($request->email)->send(new CreateAccount($data));

            User::create($request->all())->assignRole($request->role);

            //Send mail:
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            //Get role
            $role = Role::where('name', '=', $request->role)->first();
            $data['role'] = $role->display_name;
            $data['token'] = $token;
            //Send mail
            Mail::send('email.createUser', ['data' => $data], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Tạo mới người dùng thành công.');
            });
            \DB::commit();
            return redirect()->route('users.index')->with(['success' => 'Người dùng ' . $data['name'] . ' được tạo thành công.']);
        } catch (\Exception $e) {
            \DB::rollback();
            // return back()->withErrors(['msg' => $message])->withInput();
            return redirect()->route('users.index')->with(['error' => $e->getMessage()])->withInput();
        }
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
    public function update(UpdateUserRequest $request, $id)
    {
        $message = 'Đã có lỗi xảy ra. Vui lòng reload lại trang.';
        \DB::beginTransaction();
        try {
            $data = User::find($id);
            if (!$data) {
                abort(404);
            }
            //Remove role old
            $data->removeRole($data->getRoleNames()[0]);
            //Add new role
            $data->assignRole($request->role);
            $data->update($request->all());
            \DB::commit();
            return redirect()->route('users.show', $id)->with(['success' => 'Thông tin người dùng ' . $data->name . ' đã được cập nhật!!!']);
        } catch (\Exception $e) {
            \DB::rollback();
            // return back()->withErrors(['msg' => $message])->withInput();
            return redirect()->back()->with(['error' => $message])->withInput();
        }

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
        $role = Role::with('permissions')->find($id);
        // $role->hasPermissionTo('role-view');
        $parentPermissions = ParentPermission::with('permissions')->get();

        if (!$role) {
            abort(404);
        }
        return view('user.user.roleandpermission.show', compact('role', 'parentPermissions'));
    }

    public function storeRaP(Request $request)
    {

    }


    public function exportPDF()
    {
        return "Tính năng đang phát triển";
    }

    public function setPermission(Request $request)
    {
        $user = \Auth::user();
        $req = $request->all();
        $roleId = $req['role_id'];
        $permissionNm = $req['permission_nm'];
        //Set message:
        $mesg = '';
        //Get Role:
        $role = Role::find($roleId);
        if ($role->name == 'admin') {
            $mesg = 'Không được phép thay đổi quyền cho ' . $role->display_name;
        } else {
            //Set permision
            if ($role->hasPermissionTo($permissionNm)) {
                $role->revokePermissionTo($permissionNm);
                $mesg = 'Đã xóa quyền ' . $permissionNm . ' thành công cho ' . $role->display_name;
            } else {
                $role->givePermissionTo($permissionNm);
                $mesg = 'Đã xét quyền ' . $permissionNm . ' thành công cho ' . $role->display_name;
            }
        }

        return response()->json(['status_respone' => true, 'message' => $mesg]);
    }
}
