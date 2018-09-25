<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
                                            'mobile_number' => '00000000000',
                                            'whats_app_number' => '00000000000',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
    }
}
