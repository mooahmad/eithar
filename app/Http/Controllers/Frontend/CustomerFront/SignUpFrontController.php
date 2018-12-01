<?php

namespace App\Http\Controllers\Frontend\CustomerFront;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SignUpFrontController extends Controller
{
    /**
     * SignUpFrontController constructor.
     */
    public function __construct()
    {
        $this->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCustomerSignUp()
    {
        $data = [
            'gender'=>config('constants.gender_desc_'.LaravelLocalization::getCurrentLocale()),
            'countries'=>Country::all()->pluck('country_name_eng','id'),
            'cities'=>[],
        ];
        return view(FE.'.pages.customer.sign_up')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCountryCities(Request $request)
    {
        if ($request->ajax()){
            if ($request->has('country_id')){
                $cities = City::where('country_id',$request->get('country_id'))
                    ->get();
                $html='';
                if (!empty($cities)){
                    foreach ($cities as $city) {
                        $html .= '<option value="'.$city->id.'">'.$city->name.'</option>';
                    }
                }
                return response()->json(
                    [
                        'result'=>true,
                        'list'=>$html
                    ]
                );
            }
            return response()->json(
                [
                    'result'=>false,
                    'list'=>[]
                ]
            );
        }
    }
}
