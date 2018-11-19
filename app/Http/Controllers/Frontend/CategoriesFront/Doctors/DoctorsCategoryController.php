<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\Doctors;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Models\Category;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorsCategoryController extends Controller
{
    use Views;

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

    public function showDoctorQuestionnaireCalendar(Request $request)
    {
        $provider = $this->checkProviderProfile($request->provider_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider || !Auth::guard('customer-web')->check()) return redirect()->route('doctors_category');

//      set meta tags
        Utilities::setMetaTagsAttributes($provider->full_name,$provider->about,$provider->profile_picture_path);

        $family_members = Auth::guard('customer-web')->user()->family_members->pluck('full_name','id');

        $questionnaire  = $provider->services->where('type',5)->first()->questionnaire;
//        return $questionnaire->groupBy(['pagination']);
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
            'subcategory'=>$subcategory,
            'family_members'=>$family_members,
            'questionnaire'=>$questionnaire->groupBy(['pagination']),
        ];
        return view(FE.'.pages.providers.calendar_questionnaire')->with($data);
    }
    /**
     * @param $provider_id
     * @return mixed
     */
    public function checkProviderProfile($provider_id)
    {
        return Provider::GetActiveProviders()->find($provider_id);
    }

    public function drawQuestionnaire($questionnaire)
    {
//        return $questionnaire->groupBy(['pagination']);
        foreach ($questionnaire->groupBy(['pagination']) as $item=>$value){
            foreach ($value as $question){
//                draw_questionnaire
            }
        }
    }

    public function book(Request $request)
    {
        return $request->all();
    }
}
