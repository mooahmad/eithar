<?php

namespace App\Http\Controllers\Administrator\promo_codes;

use App\Http\Requests\PromoCodes\CreatePromoCodeRequest;
use App\Http\Requests\PromoCodes\UpdatePromoCodeRequest;
use App\Http\Services\Adminstrator\PromoCodeModule\ClassesPromoCode\PromoCodeClass;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class PromoCodesController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {

    }

    /**
     *
     */
    public function index()
    {
        if (Gate::denies('promo_code.view', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.promo_codes.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('promo_code.create', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        $types = config('constants.promoCodeTypes');
        $data = [
            'types' => $types,
            'formRoute' => route('promo_codes.store'),
            'submitBtn' => trans('admin.create')
        ];
        return view(AD . '.promo_codes.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreatePromoCodeRequest $request)
    {
        if (Gate::denies('promo_code.create', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        $promoCode = new PromoCode();
        PromoCodeClass::createOrUpdate($promoCode, $request);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/promo_codes');
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
        if (Gate::denies('promo_code.update', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        $promoCode = PromoCode::FindOrFail($id);
        $types = config('constants.promoCodeTypes');
        $data = [
            'types' => $types,
            'promoCode' => $promoCode,
            'formRoute' => route('promo_codes.update', ['promoCode' => $id]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.promo_codes.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdatePromoCodeRequest $request, $id)
    {
        if (Gate::denies('promo_code.update', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        $promoCode = PromoCode::findOrFail($id);
        PromoCodeClass::createOrUpdate($promoCode, $request, false);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/promo_codes');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getPromoCodesDataTable()
    {
        $promoCodes = PromoCode::where('id', '<>', 0);
        $dataTable = DataTables::of($promoCodes)
            ->addColumn('actions', function ($promoCode) {
                $editURL = url(AD . '/promo_codes/' . $promoCode->id . '/edit');
                return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    public function deletePromoCodes(Request $request)
    {
        if (Gate::denies('promo_code.delete', new PromoCode())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        return PromoCode::whereIn('id', $ids)->delete();
    }

}
