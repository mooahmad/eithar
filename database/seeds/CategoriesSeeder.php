<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                                            'profile_picture_path' => "http://13.57.87.177".'/public/images/Doctor.png',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'خدمات المختبر',
                                            'category_name_en' => 'Lab',
                                            'profile_picture_path' => "http://13.57.87.177". '/public/images/Lab.png',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'علاج طبيعى',
                                            'category_name_en' => 'Physiotherapy',
                                            'profile_picture_path' => "http://13.57.87.177". '/public/images/Physiotherapy.png',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'تمريض',
                                            'category_name_en' => 'Nursing',
                                            'profile_picture_path' => "http://13.57.87.177" . '/public/images/Nursing.png',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
        DB::table('categories')->insert([
                                            'category_name_ar' => 'أمومه و طفوله',
                                            'category_name_en' => 'WomanAndChild',
                                            'profile_picture_path' => "http://13.57.87.177" . '/public/images/Women.png',
                                            'created_at'       => \Carbon\Carbon::now()->toDateTimeString(),
                                        ]);
    }
}
