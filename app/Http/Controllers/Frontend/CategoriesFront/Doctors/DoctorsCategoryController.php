<?php

namespace App\Http\Controllers\Frontend\CategoriesFront\Doctors;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BookAppointmentProviderRequest;
use App\Http\Requests\Frontend\CheckPromoCodeRequest;
use App\Http\Services\Adminstrator\InvoiceModule\ClassesInvoice\InvoiceClass;
use App\Http\Services\WebApi\CommonTraits\Likes;
use App\Http\Services\WebApi\CommonTraits\Views;
use App\Listeners\PushNotificationEventListener;
use App\Models\Category;
use App\Models\PromoCode;
use App\Models\Provider;
use App\Models\ProvidersCalendar;
use App\Models\PushNotificationsTypes;
use App\Models\Questionnaire;
use App\Models\ServiceBooking;
use App\Models\ServiceBookingAnswers;
use App\Models\ServiceBookingAppointment;
use App\Models\TransactionsUsers;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentReminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DoctorsCategoryController extends Controller
{
    use Views,Likes;

    /**
     * DoctorsCategoryController constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showDoctorProfile(Request $request)
    {
        $provider = $this->checkProviderProfile($request->provider_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider) return redirect()->route('doctors_category');
// set meta tags
        Utilities::setMetaTagsAttributes($provider->full_name,$provider->about,$provider->profile_picture_path);

//        TODO increase number of views for provider
        if (Auth::guard('customer-web')->user()){
            $this->view($provider->id,config('constants.transactionsTypes.provider'),'View');
        }

        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
            'subcategory'=>$subcategory
        ];
        return view(FE.'.pages.providers.profile')->with($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showDoctorQuestionnaireCalendar(Request $request)
    {
        $provider = $this->checkProviderProfile($request->provider_id);

        $subcategory = Category::findOrfail($request->subcategory_id);

        if (!$provider || !Auth::guard('customer-web')->check()) return redirect()->route('doctors_category');
//        return $this->getProviderCalendar($provider);

//      set meta tags
        Utilities::setMetaTagsAttributes($provider->full_name,$provider->about,$provider->profile_picture_path);

        $family_members = Auth::guard('customer-web')->user()->family_members->pluck('full_name','id');

        $questionnaire  = $provider->services->where('type',5)->first()->questionnaire;
//        return $questionnaire->groupBy(['pagination']);
        $data = [
            'main_categories'=>Category::GetParentCategories()->get(),
            'provider'=>$provider,
            'subcategory'=>$subcategory,
            'family_members'=>$family_members,
            'questionnaire'=>$questionnaire->groupBy(['pagination']),
        ];
        return view(FE.'.pages.providers.calendar_questionnaire')->with($data);
    }
    /**
     * @param $provider_id
     * @return mixed
     */
    public function checkProviderProfile($provider_id)
    {
        return Provider::GetActiveProviders()->find($provider_id);
    }

    public function book(BookAppointmentProviderRequest $request)
    {
//        return $request->all();
        $provider = $this->checkProviderProfile($request->input('provider_id'));

        $category = Category::findOrFail($request->input('subcategory_id'));
        $service_id    = null;
        $promo_code_id = null;

        if ($category){
            $service_id = $category->services->first()->id;
        }

        if ($request->has('promo_code')){
            $promo_code = $this->checkPromoCode($request->input('promo_code'));
            if ($promo_code){
                $promo_code_id = $promo_code->id;
            }
        }

        $customer = \auth()->guard('customer-web')->user();
        $family_member = $request->input('family_member_id');
        $is_lap = 0;
        $address = (!empty($request->input('address'))) ? $request->input('address') : $customer->address;
        $comment = $request->input('comment');
        $status = config('constants.bookingStatus.inprogress');
        $status_desc = "inprogress";
        $booking = $this->saveProviderBooking($customer->id,$service_id,$provider->id,$promo_code_id,$provider->currency->id,$family_member,$is_lap,$provider->price,$comment,$address,$status,$status_desc);
        if ($booking){
            $booking_answers = $this->saveBookingAnswers($booking->id,$request->input('answer'));
            $this->saveBookingAppointments($provider,$booking->id,$request->input('slot_id'));
            PushNotificationEventListener::fireOnModel(config('constants.customer_message_cloud'), $customer);
        }
        session()->flash('success_message',trans('main.booked_appointment_success'));
        return redirect()->route('doctor_booking_meeting',['subcategory_id'=>$category->id,'subcategory_name'=>Utilities::beautyName($category->name),'provider_id'=>$provider->id,'provider_name'=>Utilities::beautyName($provider->full_name) ]);
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function getProviderCalendar($provider)
    {
        return $provider->calendar
            ->where('is_available',1)
            ->where('start_date','>=',Carbon::now()->addHours(2)->format('Y-m-d H:m:s'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCalendarDays(Request $request)
    {
        if ($request->ajax()){
            $provider = $this->checkProviderProfile($request->input('provider_id'));
            if (!$provider) return response()->json(['result'=>false,'data'=>null]);

            $calendar = $this->getProviderCalendar($provider);
            if (!$calendar) return response()->json(['result'=>false,'data'=>null]);

            return response()->json(['result'=>true,'data'=>$calendar->groupBy(['start_day'])]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableSlots(Request $request)
    {
        if ($request->ajax()){
            $provider = $this->checkProviderProfile($request->input('provider_id'));
            if (!$provider) return response()->json(['result'=>false,'data'=>null]);

            $from = Carbon::parse($request->input('selected_day'). ' 00:00:00')->format('Y-m-d H:i:s');
            $to   = Carbon::parse($request->input('selected_day'). ' 23:59:00')->format('Y-m-d H:i:s');
            $slots = $provider->calendar
                ->where('is_available',1)
                ->where('start_date','>', $from)
                ->where('start_date','<', $to)
                ->where('start_date','>=',Carbon::now()->addHours(2)->format('Y-m-d H:m:s'));
            if (count($slots)<1) return response()->json(['result'=>false,'data'=>null]);

            return response()->json(['result'=>true,'data'=>$this->drawAvailableSlots($slots)]);
        }
    }

    /**
     * @param $slots
     * @return string
     */
    public function drawAvailableSlots($slots)
    {
        $html = '';
        $appointment = '';
        foreach ($slots as $slot){
            $appointment = Carbon::parse($slot->start_date)->format("H:i") . ' : ' . Carbon::parse($slot->end_date)->format("H:i");
            $html.='
                <li class="available_dates-content">
                    <aside class="available_dates-details">
                        <i class="far fa-clock"></i> <span>'.$appointment.'</span>
                    </aside>
                    <aside class="available_dates-add">
                        <input id="'.$slot->id.'" class="date_selected-js" data-id="date'.$slot->id.'" data-value="'.$appointment.'" type="radio" name="slot_id" value="'.$slot->id.'" onclick="selectAppointment(this);">
                        <label for="'.$slot->id.'">'.trans('main.select_appointment').'</label>
                    </aside>
                </li>
            ';
        }
        return $html;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPromoCodeAndGetAmount(Request $request)
    {
        if ($request->ajax()){
            $validator = Validator::make($request->all(),(new CheckPromoCodeRequest())->rules());
            if ($validator->fails()){
                return response()->json([
                    'result' => false,
                    'message' => trans('main.error_message'),
                    'data' => '',
                    'currency'=>''
                ]);
            }

            $promo_code = $this->checkPromoCode($request->input('promo_code'));
            if (!$promo_code){
                return response()->json([
                    'result' => false,
                    'message' => trans('main.invalid_promo_code'),
                    'data' => '',
                    'currency'=>''
                ]);
            }

            if ($request->input('type') == 'Provider'){
                $service = $this->checkProviderProfile($request->input('service_id'));
            }

            if (!$service) {
                return response()->json([
                    'result' => false,
                    'message' => trans('main.error_message'),
                    'data' => '',
                    'currency'=>''
                ]);
            }

            $amount = (new InvoiceClass())->calculateInvoiceServicePrice($service->price,$promo_code->discount_percentage,Utilities::GetCustomerVAT());
            return response()->json([
                'result' => true,
                'message' => trans('main.valid_promo_code'),
                'data' => $amount,
                'currency' => ($service->currency) ? $service->currency->name : ''
            ]);
        }
    }

    /**
     * @param $code
     * @return mixed
     */
    public function checkPromoCode($code)
    {
        return PromoCode::ActivePromoCode()->where('code',$code)->first();
    }

    /**
     * @param $customer_id
     * @param $service_id
     * @param $provider_id
     * @param $promo_code_id
     * @param $currency_id
     * @param $family_member_id
     * @param $is_lap
     * @param $price
     * @param $comment
     * @param $address
     * @param $status
     * @param $status_desc
     * @return ServiceBooking
     */
    public function saveProviderBooking($customer_id,$service_id,$provider_id,$promo_code_id,$currency_id,$family_member_id,$is_lap,$price,$comment,$address,$status,$status_desc)
    {
        $booking = new ServiceBooking();
        $booking->customer_id       = $customer_id;
        $booking->service_id        = $service_id;
        $booking->provider_id       = $provider_id;
        $booking->promo_code_id     = $promo_code_id;
        $booking->currency_id       = $currency_id;
        $booking->family_member_id  = $family_member_id;
        $booking->is_lap            = $is_lap;
        $booking->price             = $price;
        $booking->comment           = $comment;
        $booking->address           = $address;
        $booking->status            = $status;
        $booking->status_desc       = $status_desc;
        $booking->save();
        return $booking;
    }

    /**
     * @param $booking_id
     * @param $Answers
     * @return mixed
     */
    public function saveBookingAnswers($booking_id, $Answers)
    {
        $data = [];
        foreach ($Answers as $key => $value) {
            $questionnaire = Questionnaire::find($key);
            $data[] = [
                "service_booking_id" => $booking_id,
                "service_questionnaire_id" => $questionnaire->id,
                "title_ar" => $questionnaire->title_ar,
                "title_en" => $questionnaire->title_en,
                "subtitle_ar" => $questionnaire->subtitle_ar,
                "subtitle_en" => $questionnaire->subtitle_en,
                "options_ar" => $questionnaire->options_ar,
                "options_en" => $questionnaire->options_en,
                "is_required" => $questionnaire->is_required,
                "rating_levels" => $questionnaire->rating_levels,
                "rating_symbol" => $questionnaire->rating_symbol,
                "order" => $questionnaire->order,
                "pagination" => $questionnaire->pagination,
                "type" => $questionnaire->type,
                "answer" => serialize($value),
            ];
        }
        return ServiceBookingAnswers::insert($data);
    }

    /**
     * @param $provider
     * @param $booking_Id
     * @param $slot_id
     * @return bool
     */
    public function saveBookingAppointments($provider, $booking_Id,$slot_id)
    {
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentConfirmed'));
        $bookingAppointment = new ServiceBookingAppointment();
        $bookingAppointment->service_booking_id = $booking_Id;
        $bookingAppointment->slot_id = $slot_id;
        $bookingAppointment->save();

        // push notification confirmation
        $pushTypeData->booking_id = $bookingAppointment->id;
        $pushTypeData->send_at = Carbon::now()->format('Y-m-d H:m:s');

        $pushTypeData->service_type = 5;
        $slot = ProvidersCalendar::find($slot_id);
        $slot->is_available = 0;
        $slot->save();
        $pushTypeData->appointment_date = $slot->start_date;
        \auth()->guard('customer-web')->user()->notify(new AppointmentConfirmed($pushTypeData));
        $provider->notify(new AppointmentConfirmed($pushTypeData));
        PushNotificationEventListener::fireOnModel(config('constants.provider_message_cloud'), $provider);
        $this->notifyBookingReminders($bookingAppointment->id, $slot->start_date, 5);
        return true;
    }

    /**
     * @param $appointmentId
     * @param $startDate
     * @param $serviceType
     */
    public function notifyBookingReminders($appointmentId, $startDate, $serviceType)
    {
        $now = Carbon::now()->format('Y-m-d H:m:s');
        $pushTypeData = PushNotificationsTypes::find(config('constants.pushTypes.appointmentReminder'));
        $pushTypeData->service_type = $serviceType;
        $pushTypeData->booking_id = $appointmentId;
        $pushTypeData->appointment_date = $startDate;
        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(3)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            \auth()->guard('customer-web')->user()->notify(new AppointmentReminder($pushTypeData));
        }

        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(24)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            \auth()->guard('customer-web')->user()->notify(new AppointmentReminder($pushTypeData));
        }

        $pushTypeData->send_at = Carbon::parse($startDate)->subHours(72)->format('Y-m-d H:m:s');
        if (strtotime($pushTypeData->send_at) > strtotime($now)) {
            \auth()->guard('customer-web')->user()->notify(new AppointmentReminder($pushTypeData));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeProvider(Request $request)
    {
        if ($request->json()){
            $data = [
                'result' => false,
                'action' => 'like',
            ];

            $customer = \auth()->guard('customer-web')->user();
            $provider_id = $request->input('provider_id');
            if ($provider_id && $customer){
                if ($this->isLikedProvider($customer->id,$provider_id)){
                    $data['result'] = true;
                    return response()->json($data);
                }
                if ($this->like($provider_id,config('constants.transactionsTypes.provider'),'Like')){
                    $data['result'] = true;
                }
            }
            return response()->json($data);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlikeProvider(Request $request)
    {
        if ($request->json()){
            $data = [
                'result' => false,
                'action' => 'unlike',
            ];

            $customer = \auth()->guard('customer-web')->user();
            $provider_id = $request->input('provider_id');
            if ($provider_id && $customer){
                if ($this->unlike($provider_id)){
                    $data['result'] = true;
                }
            }
            return response()->json($data);
        }
    }

    /**
     * @param $customer_id
     * @param $provider_id
     * @return bool
     */
    public function isLikedProvider($customer_id,$provider_id)
    {
        $is_liked = TransactionsUsers::where('user_id',$customer_id)
                                ->where('service_provider_id',$provider_id)
                                ->where('transaction_type',config('constants.transactions.like'))
                                ->where('type',config('constants.transactionsTypes.provider'))
                                ->first();
        if ($is_liked) return true;
        return false;
    }
}
