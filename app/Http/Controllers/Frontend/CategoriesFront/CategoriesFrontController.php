<?php

namespace App\Http\Controllers\Frontend\CategoriesFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoriesFrontController extends Controller
{
    public function __construct()
    {
        $this->customer = Customer::first();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDoctorsSubCategories()
    {
        $category = Category::whereNull('category_parent_id')
            ->where('id',config('constants.categories.Doctor'))
            ->first();
        if (!$category) return redirect()->route('home');
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'sub_categories'=>$category->categories,
        ];
        return view(FE.'.pages.categories.doctors.index')->with($data);
    }

    public function showLapSubCategories()
    {
        return 'Lap';
    }

    public function showPhysiotherapySubCategories()
    {
        return 'Physiotherapy';
    }

    public function showNurseSubCategories()
    {
        return 'Nurse';
    }

    public function showWomenSubCategories()
    {
        return 'Women';
    }

    public function showSubCategories(Category $category)
    {
        if (!$category) return Utilities::errorMessageAndRedirect(trans('main.error_message'),route('home'));
        return $category;
    }

    public function checkParentCategory($category)
    {
        switch ($category){
            case $category->id == config('constants.categories.Doctor'):
                return 'Doctor';
                break;

            case $category->id == config('constants.categories.Lap'):
                return 'Lap';
                break;

            case $category->id == config('constants.categories.Physiotherapy'):
                return 'Physiotherapy';
                break;

            case $category->id == config('constants.categories.Nursing'):
                return 'Nursing';
                break;

            case $category->id == config('constants.categories.WomanAndChild'):
                return 'WomanAndChild';
                break;

            default:
                return 'Not Parent';
        }
    }

    public function getSubcategoriesWithProviders($category)
    {
        if (!$category->id) return false;
        $subcategories = Category::where('category_parent_id',$category->id);
        return $subcategories;
    }

    public function getSubCategoryProvidersList(Request $request)
    {
        if ($request->ajax()){
            $subcategory_id = (int)$request->input('subcategory_id');
            $data = [
                'result'=>false,
                'list'=>$this->customer,
                'id'=>$subcategory_id
            ];

            if (empty($subcategory_id) || ! is_int($subcategory_id) || $subcategory_id<1){
                return response($data);
            }

            //get customer city
            $city_id = $this->customer->city_id;

            //get subcategory services with providers
            $services = Service::where('category_id',$subcategory_id)
                ->where('type','!=',3)->get()->pluck('id');

            $providers = Provider::GetActiveProviders()
                    ->where('is_doctor',config('constants.provider.doctor'))
                    ->join('provider_services','providers.id','=','provider_services.provider_id')
                    ->whereIn('provider_services.service_id',$services)
                    ->join('provider_cities','providers.id','=','provider_cities.provider_id')
                    ->where('provider_cities.city_id',$city_id)
                    ->get();
            if (count($providers)){
                $html = $this->buildHTMLProviderList($providers,$subcategory_id);
                $data = [
                    'result'=>true,
                    'list'=>$html,
                    'id'=>$subcategory_id
                ];
            }
            return response($data);
        }
    }

    /**
     * @param $providers
     * @param $subcategory_id
     * @return string
     */
    public function buildHTMLProviderList($providers,$subcategory_id)
    {
        $html_list = '<div class="list_doctor subCategory_'.$subcategory_id.'"> <div class="container"><div class="row">';
        foreach ($providers as $provider){
            $full_name       = $provider->full_name;
            $speciality_area = $provider->speciality_area;
            $num_likes       = $provider->no_of_likes;
            $num_rating      = $provider->no_of_ratings;
            $num_views       = $provider->no_of_views;
            $image           = $provider->profile_picture_path;
            $url             = url()->route('home');

            $html_list .= '<div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="doctor_block">
                                <a href="'.$url.'" class="doctor_img">
                                    <span class="more_details">'.trans("main.details").'</span>
                                    <img src="'.$image.'" alt="'.$full_name.'">
                                </a>
                                <div class="doctor_description">
                                        <aside class="name">
                                            <h2>'.$full_name.'</h2>
                                            <span>'.$speciality_area.'</span>
                                        </aside>

                                        <div class="rate_content">
                                            <aside>
                                                <span>'.$num_views.'</span>
                                                <img src="{{ asset(\'public/Frontend/img/icon/share.png\') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span>'.$num_rating.'</span>
                                                <img src="{{ asset(\'public/Frontend/img/icon/star.png\') }}" alt="">
                                            </aside>

                                            <aside>
                                                <span>'.$num_likes.'</span>
                                                <img src="{{ asset(\'public/Frontend/img/icon/like.png\') }}" alt="">
                                            </aside>

                                        </div>
                                    </div>
                                </div>
                            </div>';
        }
        $html_list .= '</div></div></div>';
        return $html_list;
    }
}
