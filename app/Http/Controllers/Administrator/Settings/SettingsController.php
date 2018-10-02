<?php

namespace App\Http\Controllers\Administrator\Settings;

use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Http\Services\Adminstrator\SettingsModule\ClassesSettings\SettingsClass;
use App\Models\PushNotificationsTypes;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class SettingsController extends Controller
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
    public function store($request)
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
        if (Gate::denies('settings.update', new Settings())) {
            return response()->view('errors.403', [], 403);
        }
        $settings = Settings::FindOrFail($id);
        $pushNotificationsTypes = array_flip(config('constants.pushTypes'));
        $data = [
            'settings' => $settings,
            'pushNotificationsTypes' => $pushNotificationsTypes,
            'formRoute' => route('settings.update', ['settings' => $id]),
            'submitBtn' => trans('admin.update')
        ];
        return view(AD . '.settings.form')->with($data);
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(UpdateSettingsRequest $request, $id)
    {
        if (Gate::denies('settings.update', new Settings())) {
            return response()->view('errors.403', [], 403);
        }
        $mobileNumber = $request->input('mobile_number');
        $whatsAppNumber = $request->input('whats_app_number');
        $pushTypeId = $request->input('pushNotificationsTypes');
        $titleEn = $request->input('pushTypeTitleEN');
        $titlear = $request->input('pushTypeTitleAR');
        $descEn = $request->input('desc_en');
        $descAr = $request->input('desc_ar');

        $settings = Settings::findOrFail($id);
        $pushNotificationsTypes = PushNotificationsTypes::find($pushTypeId);
        SettingsClass::update($settings, $mobileNumber, $whatsAppNumber);
        SettingsClass::updatePushType($pushNotificationsTypes, $titleEn, $titlear, $descEn, $descAr);
        SettingsClass::uploadImage($request, 'customer_banner_path', 'public/settings', $settings, 'customer_banner_path');
        session()->flash('success_msg', trans('admin.success_message'));
        return redirect(AD . '/settings/' . $id . '/edit');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

    public function getPushType(Request $request, $typeId)
    {
        return PushNotificationsTypes::find($typeId);
    }

}
