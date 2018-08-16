<?php

namespace App\Http\Controllers\Administrator\Questionnaire;

use App\Http\Requests\Categories\CreateQuestionaireRequest;
use App\Http\Requests\Categories\UpdateQuestionnaireRequest;
use App\Http\Services\Adminstrator\QuestionnaireModule\ClassesQuestionnaire\QuestionnaireClass;
use App\Models\Questionnaire;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;


class QuestionnaireController extends Controller
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
        if (Gate::denies('questionnaire.view', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        return view(AD . '.questionnaire.index');
    }

    /**
     *
     */
    public function create()
    {
        if (Gate::denies('questionnaire.create', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        $services = Service::all()->pluck('name_en', 'id')->toArray();
        $data = [
            'services' => $services,
            'formRoute'  => route('questionnaire.store'),
            'submitBtn'  => trans('admin.create')
        ];
        return view(AD . '.questionnaire.form')->with($data);
    }

    /**
     * @param Request $request
     */
    public function store(CreateQuestionaireRequest $request)
    {
        if (Gate::denies('questionnaire.create', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        $questionnaire = new Questionnaire();
        QuestionnaireClass::createOrUpdate($questionnaire, $request);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/questionnaire');
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
        if (Gate::denies('questionnaire.update', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        $questionnaire = Questionnaire::FindOrFail($id);
        $data = [
            'questionnaire'   => $questionnaire,
            'formRoute'  => route('questionnaire.update', ['questionnaire' => $id]),
            'submitBtn'  => trans('admin.update')
        ];
        return view(AD . '.questionnaire.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateQuestionnaireRequest $request, $id)
    {
        if (Gate::denies('questionnaire.update', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        $questionnaire = Questionnaire::findOrFail($id);
        QuestionnaireClass::createOrUpdate($questionnaire, $request, false);
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/questionnaire');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getQuestionnaireDataTable()
    {
        $questionnaires = Questionnaire::where('id', '<>', 0);
        $dataTable = DataTables::of($questionnaires)
                               ->addColumn('actions', function ($questionnaire) {
                                       $editURL = url(AD . '/questionnaire/' . $questionnaire->id . '/edit');
                                       return View::make('Administrator.widgets.dataTablesActions', ['editURL' => $editURL]);
                               })
                               ->rawColumns(['actions'])
                               ->make(true);
        return $dataTable;
    }

    public function deleteQuestionnaire(Request $request)
    {
        if (Gate::denies('questionnaire.delete', new Questionnaire())) {
            return response()->view('errors.403', [], 403);
        }
        $ids = $request->input('ids');
        for ($i = 1; $i <= 5; $i++)
            if (($key = array_search($i, $ids)) !== false) {
                unset($ids[$key]);
            }
        return Questionnaire::whereIn('id', $ids)->delete();
    }

}
