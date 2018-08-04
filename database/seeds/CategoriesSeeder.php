<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                                            'category_name_ar' => 'دكتور',
                                            'category_name_en' => 'Doctor',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'معمل',
                                            'category_name_en' => 'Lap',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'علاج طبيعى',
                                            'category_name_en' => 'Physiotherapy',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'تمريض',
                                            'category_name_en' => 'Nursing',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'أمومه و طفوله',
                                            'category_name_en' => 'WomanAndChild',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
    }
}
