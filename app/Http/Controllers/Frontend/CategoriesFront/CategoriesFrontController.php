<?php

namespace App\Http\Controllers\Frontend\CategoriesFront;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesFrontController extends Controller
{
    public function __construct()
    {
        
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
}
