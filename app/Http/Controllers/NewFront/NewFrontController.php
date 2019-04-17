<?php

namespace App\Http\Controllers\NewFront;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class NewFrontController extends Controller
{
    /**
     * NewFrontController constructor.
     */
    public function __construct()
    {
//
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view(NFE.'.pages.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AboutUs()
    {
        return view(NFE.'.pages.about_us');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ContactUs()
    {
        return view(NFE.'.pages.contact_us');
    }

    /**
     * @param ContactUsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function SaveContactUs(ContactUsRequest $request)
    {
        $request['ip'] = $request->ip();
        ContactUs::create($request->all());
        session()->flash('contact_success',trans('main.contact_success'));
        return back();
    }
}
