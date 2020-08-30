<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
                                            'name_ara' => 'ريال',
                                            'name_eng' => 'SAR',
                                            'currency_code' => '000',
                                            'currency_short_code' => '000',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
    }
}
