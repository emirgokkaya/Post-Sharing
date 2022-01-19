<?php

use Illuminate\Database\Seeder;

class NewsByCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\NewsByCategory::class, 5)->create();
    }
}
