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
        // $this->call(UsersTableSeeder::class);

        $divisions = factory(\App\Division::class, 5)->create();
        $divisions->each(function ($division) {
            $division
                ->employees()
                ->saveMany(
                    factory(App\Employee::class, rand(1,10))->make()
                );
        });
    }
}
