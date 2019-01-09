<?php

namespace App\Http\Services\Frontend\CategoriesServices;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ParentCategoryService extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * @param $category_id
     * @return mixed
     */
    public function getParentCategory($category_id)
    {
        return Category::whereNull('category_parent_id')->find($category_id);
    }

    /**
     * @param $subcategory_id
     * @param $type
     * @return mixed
     */
    public function getSubcategoryServices($subcategory_id,$type)
    {
        $query = Service::where('category_id',$subcategory_id)
            ->where('type',$type)
            ->where('is_active_service',1)
            ->where('expiry_date','>',Carbon::now());

        if (auth()->guard('customer-web')->check() && auth()->guard('customer-web')->user()->country_id){
            $query->where('country_id',auth()->guard('customer-web')->user()->country_id);
        }

        return $services = $query->get();
    }

    public function buildHTMLSubCategoryGlobalServicesList($services,$subcategory)
    {
        $html_list = '';

        foreach ($services as $service){
            $full_name       = $service->{'name_'.LaravelLocalization::getCurrentLocale()};
            $speciality_area = $subcategory->{'category_name_'.LaravelLocalization::getCurrentLocale()};
            $num_likes       = $service->no_of_likes;
            $num_rating      = $service->no_of_ratings;
            $num_views       = $service->no_of_views;
            $image           = $service->profile_picture_path;
            $url             = url()->route('service_profile',['subcategory_id'=>$subcategory->id,'subcategory_name'=>Utilities::beautyName($subcategory->name),'service_id'=>$service->id,'service_name'=>Utilities::beautyName($full_name)]);

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
}
