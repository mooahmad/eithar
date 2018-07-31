<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' 		=> "Super",
            'middle_name' 		=> "Eithar",
            'last_name' 		=> "Admin",
            'email' 			=> 'admin@admin.com',
            'user_type'         => 0,
            'is_active'			=> 1,
            'password'			=> bcrypt('secret'),
            'created_at'        => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
