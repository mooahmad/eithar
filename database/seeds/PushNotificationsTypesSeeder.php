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
        $types = config('constants.pushTypes');
        $data = [];
        foreach ($types as $key => $value)
            $data[] = [
                'type' => $value,
                'title_ar' => $key,
                'title_en' => $key,
                'desc_ar' => '',
                'desc_en' => '',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
        DB::table('push_notifications_types')->insert($data);
    }
}
