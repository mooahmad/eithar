<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\Doctors;

use App\Helpers\Utilities;
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showDoctorProfile(Request $request)
    {
        $provider = $this->checkProviderProfile($request->provider_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider) return redirect()->route('doctors_category');
// set meta tags
        Utilities::setMetaTagsAttributes($provider->full_name,$provider->about,$provider->profile_picture_path);

//        TODO increase number of views for provider

        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
            'subcategory'=>$subcategory
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
