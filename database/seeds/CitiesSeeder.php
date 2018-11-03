<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
                                        'country_id'    => 2,
                                        'city_name_ara' => "رياض",
                                        'city_name_eng' => "Riyadh",
                                        'city_code'     => '682',
                                        'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]);

        DB::table('cities')->insert([
                                        'country_id'    => 2,
                                        'city_name_ara' => "جدة",
                                        'city_name_eng' => "Jeddah",
                                        'city_code'     => '682',
                                        'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "مكة المكرمة",
            'city_name_eng' => "Mecca",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "الهفوف‎‎",
            'city_name_eng' => "Hofuf",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "الطائف",
            'city_name_eng' => "Ta'if",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "الدمام",
            'city_name_eng' => "Dammam",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "خـميــس مشيـــط",
            'city_name_eng' => "Khamis Mushayt",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "بريدة",
            'city_name_eng' => "Buraydah",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "الخبر‎‎",
            'city_name_eng' => "Al-Khobar",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "تبوك",
            'city_name_eng' => "Tabuk",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "حائل",
            'city_name_eng' => "Ha'il City",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "حفر الباطن",
            'city_name_eng' => "Hafr Al Batin",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "الجبيل",
            'city_name_eng' => "Jubail",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "السيح‎‎",
            'city_name_eng' => "Al Saih",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "القطيف",
            'city_name_eng' => "Qatif",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "أبها",
            'city_name_eng' => "Abha",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "نجران‎‎",
            'city_name_eng' => "Najran",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "ينبع البحر",
            'city_name_eng' => "Yanbu' Al Bahr",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        DB::table('cities')->insert([
            'country_id'    => 2,
            'city_name_ara' => "القنفذة",
            'city_name_eng' => "Al Qunfudhah",
            'city_code'     => '682',
            'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
