<?php

namespace App\Http\Controllers\Frontend\CategoriesFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\CategoriesServices\ParentCategoryService;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoriesFrontController extends Controller
{
    protected $ParentService;

    public function __construct()
    {
        $this->ParentService = new ParentCategoryService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDoctorsSubCategories()
    {
        $category = Category::whereNull('category_parent_id')
            ->find(config('constants.categories.Doctor'));
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showNurseSubCategories()
    {
        $category = $this->ParentService->getParentCategory(config('constants.categories.Nursing'));
        if (!$category) return redirect()->route('home');
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'sub_categories'=>$category->categories,
        ];
        return view(FE.'.pages.categories.global_categories.index')->with($data);
    }

    public function showWomenSubCategories()
    {
        return 'MotherAndChildCare';
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSubCategoryProvidersList(Request $request)
    {
        if ($request->ajax()){
            $subcategory = Category::findOrFail($request->input('subcategory_id'));
            $data = [
                'result'=>false,
                'list'=>'',
                'id'=>''
            ];

            if (empty($subcategory)){
                return response($data);
            }

            //get subcategory services with providers
            $services = $subcategory->services()
                ->where('type','!=',3)->get()->pluck('id');

            $query = Provider::GetActiveProviders()
                    ->where('is_doctor',config('constants.provider.doctor'));

            if (!empty($services)){
                $query->join('provider_services','providers.id','=','provider_services.provider_id')
                    ->whereIn('provider_services.service_id',$services);
            }

            if (auth()->guard('customer-web')->check() && auth()->guard('customer-web')->user()->city_id){
                $query->join('provider_cities','providers.id','=','provider_cities.provider_id')
                    ->where('provider_cities.city_id',auth()->guard('customer-web')->user()->city_id);
            }

            $providers = $query->select(['providers.*'])->get();
            if (count($providers)){
                $html = $this->buildHTMLProviderList($providers,$subcategory);
                $data = [
                    'result'=>true,
                    'list'=>$html,
                    'id'=>$subcategory->id
                ];
            }
            return response($data);
        }
    }

    /**
     * @param $providers
     * @param $subcategory
     * @return string
     */
    public function buildHTMLProviderList($providers,$subcategory)
    {
        $html_list = '<div class="list_doctor subCategory_'.$subcategory->id.'"> <div class="container"><div class="row">';

        foreach ($providers as $provider){
            $full_name       = $provider->full_name;
            $speciality_area = $provider->speciality_area;
            $num_likes       = $provider->no_of_likes;
            $num_rating      = $provider->no_of_ratings;
            $num_views       = $provider->no_of_views;
            $image           = $provider->profile_picture_path;
            $url             = url()->route('doctor_profile',['subcategory_id'=>$subcategory->id,'subcategory_name'=>Utilities::beautyName($subcategory->name),'provider_id'=>$provider->id,'provider_name'=>Utilities::beautyName($full_name)]);

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
                                                <span>'.$num_likes.'</span>
                                                <i class="far fa-heart"></i>
                                            </aside>

                                            <aside>
                                                <span>'.$num_rating.'</span>
                                                <i class="far fa-star"></i>
                                            </aside>

                                            <aside>
                                                <span>'.$num_views.'</span>
                                                <i class="far fa-eye"></i>
                                            </aside>

                                        </div>
                                    </div>
                                </div>
                            </div>';
        }
        $html_list .= '</div></div></div>';
        return $html_list;
    }

    public function getSubCategoryGlobalServicesList(Request $request){
        if ($request->ajax()){
            $subcategory = Category::findOrFail($request->input('subcategory_id'));
            $data = [
                'result'=>false,
                'id'=>'',
                'package_list'=>'',
                'one_time_visit_list'=>'',
            ];

            if (empty($subcategory)){
                return response($data);
            }

            //get subcategory one time visit services
            $one_time_visit_services = $this->ParentService->getSubcategoryServices($subcategory->id,1);

            //get subcategory packages services
            $packages_services = $this->ParentService->getSubcategoryServices($subcategory->id,2);

            if (count($packages_services)) {
                $data['package_list'] = $this->ParentService->buildHTMLSubCategoryGlobalServicesList($packages_services, $subcategory);
            }
            if (count($one_time_visit_services)){
                $data['one_time_visit_list'] = $this->ParentService->buildHTMLSubCategoryGlobalServicesList($one_time_visit_services,$subcategory);
            }
            $data['result']=true;
            $data['id']=$subcategory->id;
            return response($data);
        }
    }
}
