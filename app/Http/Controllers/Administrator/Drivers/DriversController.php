<?php

namespace App\Http\Controllers\Administrator\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drivers\CreateDriverRequest;
use App\Http\Requests\Drivers\UpdateDriverRequest;
use App\Http\Services\Adminstrator\DriversModule\ClassesDrivers\DriversClass;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;

class DriversController extends Controller
{
    /**
     * CategoriesController constructor.
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
        if (Gate::denies('drivers.view', new Driver())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.drivers.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('drivers.create', new Driver())) {
            return response()->view('errors.403', [], 403);
        }
        $data = [
            'formRoute' => route('drivers.store'),
            'submitBtn' => trans('admin.create'),
        ];
        return view(AD . '.drivers.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateDriverRequest $request)
    {
        if (Gate::denies('drivers.create', new Driver())) {
            return response()->view('errors.403', [], 403);
        }

        $driver = new Driver();
        $name = $request->input('name');
        $identity = $request->input('identity');
        $nationalId = $request->input('nationalId');
        $carType = $request->input('carType');
        $carColor = $request->input('carColor');
        $carPlateNumber = $request->input('carPlateNumber');
        $status = $request->input('status');
        DriversClass::createOrUpdate($driver, $name, $identity, $nationalId, $carType, $carColor, $carPlateNumber, $status);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/drivers');
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
        if (Gate::denies('drivers.update', new Driver())) {
            return response()->view('errors.403', [], 403);
        }
        $driver = Driver::FindOrFail($id);
        $data = [
            'driver' => $driver,
            'formRoute' => route('drivers.update', ['driver' => $id]),
            'submitBtn' => trans('admin.update'),
        ];
        return view(AD . '.drivers.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateDriverRequest $request, $id)
    {
        if (Gate::denies('drivers.update', new Driver())) {
            return response()->view('errors.403', [], 403);
        }
        $driver = Driver::findOrFail($id);
        $name = $request->input('name');
        $identity = $request->input('identity');
        $nationalId = $request->input('nationalId');
        $carType = $request->input('carType');
        $carColor = $request->input('carColor');
        $carPlateNumber = $request->input('carPlateNumber');
        $status = $request->input('status');
        DriversClass::createOrUpdate($driver, $name, $identity, $nationalId, $carType, $carColor, $carPlateNumber, $status);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/drivers');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getDriversDataTable()
    {
        $drivers = Driver::where('id', '<>', 0);
        $dataTable = DataTables::of($drivers)
            ->addColumn('actions', function ($driver) {
                $editURL = url(AD . '/drivers/' . $driver->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    public function deleteDrivers(Request $request)
    {
        if (Gate::denies('drivers.delete', new Driver())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return Driver::whereIn('id', $ids)->delete();
    }

}
