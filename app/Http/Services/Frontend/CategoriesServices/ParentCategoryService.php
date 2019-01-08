<?php

namespace App\Http\Services\Frontend\CategoriesServices;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
}
