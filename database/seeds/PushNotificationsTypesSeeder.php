<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PushNotificationsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('push_notifications_types')->insert([
            'type' => 1,
            'title_ar' => 'خدمات',
            'title_en' => 'Services',
            'desc_ar' => 'This is a default message',
            'desc_en' => 'This is a default message',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 2,
            'title_ar' => 'أطباء',
            'title_en' => 'Doctors',
            'desc_ar' => 'This is a default message',
            'desc_en' => 'This is a default message',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 3,
            'title_ar' => 'تذكير بموعد الجلسة',
            'title_en' => 'Appointment Reminder',
            'desc_ar' => 'نحيط سيادتكم علما بأن موعد الجلسة فى @day فى تمام الساعة @time',
            'desc_en' => 'your Doctor appointment will be in @day at @time',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 4,
            'title_ar' => 'تأكيد بموعد الجلسة',
            'title_en' => 'Appointment Confirmed',
            'desc_ar' => 'نحيط سيادتكم علما بأن موعد الجلسة فى @day فى تمام الساعة @time',
            'desc_en' => 'your Doctor appointment will be in @day at @time',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 5,
            'title_ar' => 'اضافة تقريرك الطبي',
            'title_en' => 'Medical Report Added',
            'desc_ar' => 'تم اضافه تقرير طبى الى حسابك',
            'desc_en' => 'Your medical report has been added to your profile',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 6,
            'title_ar' => 'اضافة فاتورة',
            'title_en' => 'Invoice Generated',
            'desc_ar' => 'تم اضافه فاتورة الى حسابك',
            'desc_en' => 'here is your new invoice',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 7,
            'title_ar' => 'اضافة خدمة جديدة',
            'title_en' => 'Add Item To Invoice',
            'desc_ar' => 'لقد قمت باضافه خدمه على فاتورتك',
            'desc_en' => 'you have added a new service, it has been added in your invoice',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 8,
            'title_ar' => 'الغاء موعد',
            'title_en' => 'Appointment Canceled',
            'desc_ar' => 'لقد تم الفاء موعد',
            'desc_en' => 'Appointment has been canceled',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('push_notifications_types')->insert([
            'type' => 9,
            'title_ar' => 'الغاء موعد',
            'title_en' => 'تعيين دكتور للاجتماع',
            'desc_ar' => 'تعيين دكتور للاجتماع',
            'desc_en' => 'Assign Provider To Meeting',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
