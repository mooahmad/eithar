<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             OAuthSeeder::class,
             UsersSeeder::class,
             CategoriesSeeder::class,
             CountriesSeeder::class,
             CitiesSeeder::class,
             CurrenciesSeeder::class,
             PushNotificationsTypesSeeder::class,
         ]);
    }
}
