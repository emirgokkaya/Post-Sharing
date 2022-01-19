<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'id' => 1,
           'name' => 'Emir Gökkaya',
           'email' => 'postemir@yandex.com',
           'avatar' => 'http://postin.local/assets/images/users/8.jpg',
            'role' => 'admin',
            'email_verified_at' => \Illuminate\Support\Carbon::now(),
            'password' => bcrypt('Laravel!.5858'),
            'state' => 1,
            'verified' => 1,
            'email_token' => \Illuminate\Support\Str::random(60),
            'remember_token' => \Illuminate\Support\Str::random(60),
            'created_at' => \Illuminate\Support\Carbon::now(),
            'updated_at' => \Illuminate\Support\Carbon::now()
        ]);
    }
}
