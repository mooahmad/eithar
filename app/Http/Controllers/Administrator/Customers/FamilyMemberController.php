<?php
namespace App\Http\Controllers\Administrator\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFamily\FamilyMemberRequest;
use App\Http\Services\Adminstrator\UsersModule\ClassesUsers\FamilyMemberClass;
use App\Models\Customer;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FamilyMemberRequest $request)
    {
        if(Gate::denies('family_member.create')){
            return response()->view('errors.403',[],403);
        }
        $family_member = FamilyMemberClass::createOrUpdateFamilyMember(new FamilyMember(),$request);

        dd($family_member);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
