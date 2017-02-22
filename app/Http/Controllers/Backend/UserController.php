<?php

namespace App\Http\Controllers\Backend;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Requests\Backend;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\PermissionRepository;
use Laracasts\Flash\Flash;
use App\Models\User;
use DB;
use Zizaco\Entrust\Entrust;
use Auth;

class UserController extends BaseController
{

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;


    /**
     * @param UserRepository        $users
     * @param RoleRepository        $roles
     * @param PermissionRepository    $permissions
     */
    public function __construct(UserRepository $users, RoleRepository $roles, PermissionRepository $permissions)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->orderBy('id', 'desc')->paginate(10);

        return view('backend.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.user.create',
            [
                'roles' => $this->roles->all(),
                'userRoles' => array()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     */
    public function store(Backend\CreateUserRequest $request)
    {
        $data = $request->only(['username', 'email', 'password', 'role_ids', 'status']);
        if(!isset($data['status']))
            $data['status'] = 0;
        $data['uid'] = genId();
        try {
            DB::transaction(function () use ($data) {
                $role_ids = explode(",", $data['role_ids']);
                unset($data['role_ids']);
                $user = User::create($data);
                foreach($role_ids as $role_id) {
                    $user->roles()->attach($role_id);
                }
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('jsmsg', amaran_msg(trans('message.create_user_failed'), 'error'));
        }
        return redirect()->route('admin.auth.user.index')->with('jsmsg', amaran_msg(trans('message.create_user_success'), 'success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->users->find($id);
        $roleIds = $user->getRoleIds();
        return view(
            'backend.user.edit',
            [
                'user' => $user,
                'userRoles' => $user->roles->pluck('id')->all(),
                'roles' => $this->roles->all(),
                'roleIds' => $roleIds
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int    $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Backend\UpdateUserRequest $request)
    {
        $data = $request->only(['username', 'email', 'password', 'role_ids', 'status']);
        $user = User::findOrFail($id);
        if(!isset($data['status']))
            $data['status'] = 0;
        try {
            DB::transaction(function () use ($user, $data) {
                $role_ids = explode(",", $data['role_ids']);
                unset($data['role_ids']);
                $user->username = $data['username'];
                if(trim($data['password']) != '')
                    $user->password = \Hash::make($data['password']);
                $user->status = $data['status'];
                $user->save();
                $user->roles()->sync($role_ids);
            });
        } catch(\Exception $e) {
            return redirect()->back()->with('jsmsg', amaran_msg(trans('message.update_user_failed'), 'error'));
        }
        return redirect()->route('admin.auth.user.index')->with('jsmsg', amaran_msg(trans('message.update_user_success'), 'success'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function changePassword($id, Request $request) {
        return view('backend.user.change-password')
            ->withUser($this->users->find($id));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updatePassword($id, Request $request) {
        $this->users->updatePassword($id, $request->all());
        return redirect()->route('admin.auth.user.index')->with('jsmsg', amaran_msg(trans('alerts.users.updated_password'), 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if(\Entrust::hasRole('admin')) {
            $this->users->destroy($id);
            return redirect()
                ->route('admin.auth.user.index')
                ->with('jsmsg', amaran_msg(trans('alerts.users.deleted'), 'success'));
        }
        return view('backend.errors.401');
    }

    public function expdriverHome(Request $request) {
        if(\Entrust::ability('admin,exp_driver', 'decorate-home'))
            return view('backend.user.expdriver-home', [
                'user' => Auth::user()
            ]);
        return view('backend.errors.401');
    }

    public function expdriverHomeStore(Request $request) {
        $data = $request->only(['real_name', 'password','password_confirmation', 'id_no', 'mobile', 'keye_age', 'quotation', 'avatar', 'nest_info']);
        if(isset($data['password']) && $data['password'] == '')
            unset($data['password']);
        if(isset($data['password']) && isset($data['password_confirmation']) && $data['password'] != $data['password_confirmation']) {
            return redirect()
                ->route('admin.expdriver.decorate')
                ->with('jsmsg', amaran_msg(trans('message.password_not_match'), 'success'));
        }
        if(isset($data['password_confirmation']))
            unset($data['password_confirmation']);
        $data['user_id'] = Auth::user()->id;
        UserProfile::updateOrCreate(['user_id' => $data['user_id']], $data);
        return redirect()
            ->route('admin.expdriver.decorate')
            ->with('jsmsg', amaran_msg(trans('message.update_user_success'), 'success'));
    }
}
