<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'first_name' => 'Tanvir',
            'last_name' => 'Reza',
            'gender' => 'm',
            'email' => 'ConAdmin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 1,
            'email_verified_at' => now()
        ];
        User::create($user);
    }
}
