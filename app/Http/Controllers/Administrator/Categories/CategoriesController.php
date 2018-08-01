<?php

namespace App\Http\Controllers\Administrator\Categories;

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

    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {

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

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {

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
                                   $editURL = url('Administrator/categories/' . $category->id . '/edit');
                                   return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
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
        if (($key = array_search(-1, $ids)) !== false) {
            unset($ids[$key]);
        }
        return Category::whereIn('id', $ids)->delete();
    }

}
