<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\Doctors;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Models\Category;
use App\Models\Provider;
use Carbon\Carbon;
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showDoctorQuestionnaireCalendar(Request $request)
    {
        $provider = $this->checkProviderProfile($request->provider_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider || !Auth::guard('customer-web')->check()) return redirect()->route('doctors_category');
//        return $this->getProviderCalendar($provider);

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

    public function book(Request $request)
    {
        return $request->all();
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function getProviderCalendar($provider)
    {
        return $provider->calendar
            ->where('is_available',1)
            ->where('start_date','>=',Carbon::now()->addHours(2)->format('Y-m-d H:m:s'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCalendarDays(Request $request)
    {
        if ($request->ajax()){
            $provider = $this->checkProviderProfile($request->input('provider_id'));
            if (!$provider) return response()->json(['result'=>false,'data'=>null]);

            $calendar = $this->getProviderCalendar($provider);
            if (!$calendar) return response()->json(['result'=>false,'data'=>null]);

            return response()->json(['result'=>true,'data'=>$calendar->groupBy(['start_day'])]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableSlots(Request $request)
    {
        if ($request->ajax()){
            $provider = $this->checkProviderProfile($request->input('provider_id'));
            if (!$provider) return response()->json(['result'=>false,'data'=>null]);

            $from = Carbon::parse($request->input('selected_day'). ' 00:00:00')->format('Y-m-d H:i:s');
            $to   = Carbon::parse($request->input('selected_day'). ' 23:59:00')->format('Y-m-d H:i:s');
            $slots = $provider->calendar
                ->where('is_available',1)
                ->where('start_date','>', $from)
                ->where('start_date','<', $to)
                ->where('start_date','>=',Carbon::now()->addHours(2)->format('Y-m-d H:m:s'));
            if (count($slots)<1) return response()->json(['result'=>false,'data'=>null]);

            return response()->json(['result'=>true,'data'=>$this->drawAvailableSlots($slots)]);
        }
    }

    /**
     * @param $slots
     * @return string
     */
    public function drawAvailableSlots($slots)
    {
        $html = '';
        foreach ($slots as $slot){
            $html.='
                <li class="available_dates-content">
                    <aside class="available_dates-details">
                        <i class="far fa-clock"></i> <span>'.Carbon::parse($slot->start_date)->format("H:i").'
                        : '.Carbon::parse($slot->end_date)->format("H:i").'</span>
                    </aside>
                    <aside class="available_dates-add">
                        <input id="'.$slot->id.'" class="date_selected-js" data-id="date'.$slot->id.'" type="radio" name="slot_id" value="'.$slot->id.'">
                        <label for="'.$slot->id.'">'.trans('main.select_appointment').'</label>
                    </aside>
                </li>
            ';
        }
        return $html;
    }
}
