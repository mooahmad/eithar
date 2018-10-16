<?php
namespace App\Http\Controllers\Administrator\Customers;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFamily\FamilyMemberRequest;
use App\Http\Services\Adminstrator\UsersModule\ClassesUsers\FamilyMemberClass;
use App\Models\Customer;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class FamilyMemberController extends Controller
{
    /**
     * FamilyMemberController constructor.
     */
    public function __construct()
    {
        $this->middleware('AdminAuth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('family_member.view')){
            return response()->view('errors.403',[],403);
        }
        return view(AD.'.family_member.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('family_member.create')){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'customers'=>Customer::GetActiveCustomers()->get()->pluck('full_name','id'),
            'relation_types'=>config('constants.MemberRelations_desc'),
            'gender_types'=>config('constants.gender_desc')
        ];
        return view(AD.'.family_member.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FamilyMemberRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(FamilyMemberRequest $request)
    {
        if(Gate::denies('family_member.create')){
            return response()->view('errors.403',[],403);
        }
        $family_member = FamilyMemberClass::createOrUpdateFamilyMember(new FamilyMember(),$request);
        if ($request->hasFile('profile_picture_path')){
            $image = Utilities::UploadFile($request->file('profile_picture_path'),'public/images/familymembers');
            if ($image){
                $family_member->profile_picture_path = $image;
                $family_member->save();
            }
        }
        session()->flash('success_msg',trans('admin.success_message'));
        return redirect()->route('all_family_members');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('family_member.update')){
            return response()->view('errors.403',[],403);
        }
        $data = [
            'form_data'=>FamilyMember::findOrFail($id),
            'customers'=>Customer::GetActiveCustomers()->get()->pluck('full_name','id'),
            'relation_types'=>config('constants.MemberRelations_desc'),
            'gender_types'=>config('constants.gender_desc')
        ];
        return view(AD.'.family_member.form')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FamilyMemberRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(FamilyMemberRequest $request, $id)
    {
        if(Gate::denies('family_member.update')){
            return response()->view('errors.403',[],403);
        }
        $family_member_data = FamilyMember::findOrFail($id);
        $family_member = FamilyMemberClass::createOrUpdateFamilyMember($family_member_data,$request);
        if ($request->hasFile('profile_picture_path')){
            $image = Utilities::UploadFile($request->file('profile_picture_path'),'public/images/familymembers',$family_member_data->profile_picture_path);
            if ($image){
                $family_member->profile_picture_path = $image;
                $family_member->save();
            }
        }
        session()->flash('success_msg',trans('admin.success_message'));
        return redirect()->route('all_family_members');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteFamilyMembers(Request $request)
    {
        if(Gate::denies('family_member.delete')){
            return response()->view('errors.403',[],403);
        }
        if ($request->has('ids')) {
            foreach ($request->get('ids') as $id) {
                $delete = FamilyMember::FindOrFail($id);
//            if ($delete->profile_picture_path)
//            {
//                Utilities::UploadFile($request->file('profile_picture_path'),'public/images/familymembers',$delete->profile_picture_path);
//            }
                $delete->delete();
            }
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getFamilyMembersDataTable()
    {
        $family_members = FamilyMember::where('id', '<>', 0);
        $dataTable = DataTables::of($family_members)
            ->addColumn('image', function ($item) {
                if (!empty($item->profile_picture_path)) {
                    $Image = Utilities::getFileUrl($item->profile_picture_path);
                    return '<td><a href="' . $Image . '" data-lightbox="image-1" data-title="' . $item->id . '" class="text-success">Show <i class="fa fa-image"></i></a></td>';
                } else {
                    return '<td><span class="text-danger">No Image</span></td>';
                }
            })
            ->addColumn('parent',function ($item){
                return $item->parent->full_name;
            })
            ->addColumn('full_name',function ($item){
                return $item->full_name;
            })
            ->addColumn('mobile_number',function ($item){
                return $item->mobile_number;
            })
            ->addColumn('relation_type',function ($item){
                return config('constants.MemberRelations_desc.'.$item->relation_type);
            })
            ->addColumn('national_id',function ($item){
                return $item->national_id;
            })
            ->addColumn('actions', function ($item) {
                $showURL = route('show_family_members',[$item->id]);
                $editURL = route('edit_family_members',[$item->id]);
                $URLs = [
                    ['link'=>$showURL,'icon'=>'eye','color'=>'green'],
                    ['link'=>$editURL,'icon'=>'edit','color'=>'purple'],
                ];
                return View::make('Administrator.widgets.advancedActions', ['URLs'=>$URLs]);
            })
            ->rawColumns(['image','full_name','parent','actions'])
            ->make(true);
        return $dataTable;
    }
}
