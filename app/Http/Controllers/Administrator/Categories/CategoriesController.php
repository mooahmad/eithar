<?php

namespace App\Http\Controllers\Administrator\Categories;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Services\Adminstrator\CategoryModule\ClassesCategory\CategoryClass;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class CategoriesController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {

    }

    /**
     *
     */
    public function index()
    {
        if (Gate::denies('category.view', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.categories.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('category.create', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        $categories = Category::all()->take(5)->pluck(__('admin.cat_name_col'), 'id')->toArray();
        $data = [
            'categories' => $categories,
            'formRoute'  => route('categories.store'),
            'submitBtn'  => trans('admin.create')
        ];
        return view(AD . '.categories.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateCategoryRequest $request)
    {
        if (Gate::denies('category.create', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        $category = new Category();
        CategoryClass::createOrUpdate($category, $request);
        CategoryClass::uploadImage($request, 'avatar', 'public/images/categories', $category,'profile_picture_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(CAT . '/categories');
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        if (Gate::denies('category.update', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        $category = Category::FindOrFail($id);
        $categories = Category::all()->take(5)->pluck(__('admin.cat_name_col'), 'id')->toArray();
        $data = [
            'category'   => $category,
            'categories' => $categories,
            'formRoute'  => route('categories.update', ['category' => $id]),
            'submitBtn'  => trans('admin.update')
        ];
        return view(AD . '.categories.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        if (Gate::denies('category.update', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        $category = Category::findOrFail($id);
        CategoryClass::createOrUpdate($category, $request, false);
        CategoryClass::uploadImage($request, 'avatar', 'public/images/categories', $category,'profile_picture_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(CAT . '/categories');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getCategoriesDataTable()
    {
        $categories = Category::where('id', '<>', 0);
        $dataTable = DataTables::of($categories)
                               ->addColumn('actions', function ($category) {
                                   if (!in_array($category->id, [1, 2, 3, 4, 5])) {
                                       $editURL = url('Categories/categories/' . $category->id . '/edit');
                                       return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                                   }
                               })
                               ->rawColumns(['actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteCategories(Request $request)
    {
        if (Gate::denies('category.delete', new Category())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        for ($i = 1; $i <= 5; $i++)
            if (($key = array_search($i, $ids)) !== false) {
                unset($ids[$key]);
            }
        return Category::whereIn('id', $ids)->delete();
    }

}
