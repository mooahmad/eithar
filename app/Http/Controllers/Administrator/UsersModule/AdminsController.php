<?php

namespace App\Http\Controllers\Administrator\UsersModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePassAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Services\Adminstrator\UsersModule\ClassesUsers\AdminClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * AdminsController constructor.
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'all' => User::all(),
        ];
        return view(AD . '.admins.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'tab' => 'new_user'
        ];
        return view(AD . '.admins.form_new')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return array
     */
    public function store(CreateAdminRequest $request)
    {
        $user = new User();
        AdminClass::createOrUpdateAdmin($user, $request);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/admins');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::FindOrFail($id);
//        return $user;
        $data = [
            'form_data' => $user,
            'tab'       => 'personal_information'
        ];
        return view(AD . '.admins.form_new')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateAdminRequest $request, $id)
    {
        $inputs = $request->except('_token', '_method');
        User::FindOrFail($id)->update($inputs);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Logout clear session to user.
     *
     * @return to login page
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('login');
    }

    /**
     * @param ChangePassAdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function userUpdatePassword(ChangePassAdminRequest $request, $id)
    {
        $user = User::FindOrFail($id);
        $user->password = bcrypt($request->input('password'));
        $user->save();
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/admins');
    }
}
