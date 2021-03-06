<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FrontendController extends Controller
{
    /**
     * FrontendController constructor.
     */
    public function __construct()
    {
//        App::setLocale(session()->get('lang'));
//        $this->middleware('Language');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
        ];
//        return view(FE.'.landing_page')->with($data);
        return view(FE.'.index')->with($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AboutUs()
    {
        return view(FE.'.pages.static.about_us');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PrivacyAndConditions()
    {
        return view(FE.'.pages.static.privacy_and_conditions');
    }
}
