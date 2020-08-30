<?php

namespace App\Http\Controllers\Administrator\Joinus;

use App\Http\Controllers\Controller;
use App\Models\JoinUs;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class JoinusController extends Controller
{
    /**
     * JoinusController constructor.
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        if (Gate::denies('settings.view', new Settings())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.joinus.index');
    }

    /**
     *
     */
    public function create()
    {

    }

    /**
     * @param Request $request
     */
    public function store($request)
    {

    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update($request, $id)
    {

    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getJoinusDataTable()
    {
        $joinUs = JoinUs::where('id', '<>', 0);
        $dataTable = DataTables::of($joinUs)
            ->addColumn('actions', function ($category) {
                    return "";
            })
            ->addColumn('city_id',function ($item){
                return $item->country->country_name_eng;
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

}
