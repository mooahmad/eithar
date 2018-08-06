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
                                        'city_name_ara' => "جده",
                                        'city_name_eng' => "Gadah",
                                        'city_code'     => '682',
                                        'created_at'    => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]);
    }
}
