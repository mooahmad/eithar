<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\Doctors;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Provider;
use Illuminate\Http\Request;

class DoctorsCategoryController extends Controller
{
    /**
     * DoctorsCategoryController constructor.
     */
    public function __construct()
    {
        //
    }

    public function showDoctorProfile(Request $request)
    {
        $provider = $this->checkProviderProfile($request->id);
        if (!$provider) return redirect()->route('doctors_category');
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
        ];
        return view(FE.'.pages.providers.profile')->with($data);
    }

    /**
     * @param $provider_id
     * @return mixed
     */
    public function checkProviderProfile($provider_id)
    {
        return Provider::GetActiveProviders()->find($provider_id);
    }
}
