<?php

namespace App\Http\Controllers\Administrator\UsersModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePassAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Services\Adminstrator\UsersModule\ClassesUsers\AdminClass;
use App\Mail\Auth\VerifyEmailCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Symfony\Component\Routing\Route;
use Yajra\DataTables\Facades\DataTables;

class AdminsController extends Controller
{
    /**
     * AdminsController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('admins.view', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('admins.create', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        $data = [
            'languages'     => array(
                'english',
                'arabic'
            ),
            'nationalities' => array(
                'Egyptian',
                'Saudian'
            ),
            'formRoute'     => route('admins.store'),
            'submitBtn'     => trans('admin.update')
        ];
        return view(AD . '.admins.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return array
     */
    public function store(CreateAdminRequest $request)
    {
        if (Gate::denies('admins.create', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        $user = new User();
        AdminClass::createOrUpdateAdmin($user, $request);
        AdminClass::uploadAdminImage($request, 'avatar', 'public/images/avatars', $user, 'profile_picture_path');
        AdminClass::uploadAdminImage($request, 'national_id_picture', 'public/images/nationalities', $user, 'nationality_id_picture');
        Mail::to($user->email)->send(new VerifyEmailCode($user));
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
        if (Gate::denies('admins.update', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        $user = User::FindOrFail($id);
        $data = [
            'user'          => $user,
            'languages'     => array(
                'english',
                'arabic'
            ),
            'nationalities' => array(
                'Egyptian',
                'Saudian'
            ),
            'formRoute'     => route('admins.update', ['admin' => $id]),
            'submitBtn'     => trans('admin.update')
        ];
        return view(AD . '.admins.form')->with($data);
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
        if (Gate::denies('admins.update', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        AdminClass::createOrUpdateAdmin(User::findOrFail($id), $request, false);
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


    public function getAdminsDataTable()
    {
        $admins = User::where('id', '<>', 0);
        $dataTable = DataTables::of($admins)
                               ->addColumn('actions', function ($admin) {
                                   $editURL = url('Administrator/admins/' . $admin->id . '/edit');
                                   return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                               })
                               ->rawColumns(['actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteAdmins(Request $request)
    {
        if (Gate::denies('admins.delete', Auth::user())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        if (($key = array_search(1, $ids)) !== false) {
            unset($ids[$key]);
        }
        return User::whereIn('id', $ids)->delete();
    }
}
