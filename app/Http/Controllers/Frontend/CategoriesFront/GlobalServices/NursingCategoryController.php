<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\GlobalServices;

use App\Http\Controllers\Controller;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NursingCategoryController extends Controller
{
    use Views,Likes;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showServiceProfile(Request $request)
    {
        $provider = $this->checkProviderProfile($request->service_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider) return redirect()->route('doctors_category');
// set meta tags
        Utilities::setMetaTagsAttributes($provider->full_name,$provider->about,$provider->profile_picture_path);

//        TODO increase number of views for provider
        if (Auth::guard('customer-web')->user()){
            $this->view($provider->id,config('constants.transactionsTypes.provider'),'View');
        }

        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
            'subcategory'=>$subcategory
        ];
        return view(FE.'.pages.providers.profile')->with($data);
    }
}
