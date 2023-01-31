<?php

namespace Database\Seeders\Externals;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users_data = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$Ikvr04D7eCwtFbrtMZ/gFOcfWB6Pj22powYpyhvrQMME5w2GSSAhm', //admin
                'is_admin' => 1
            ],
            [
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'password' => '$2y$10$Rq06QA2AO0EffxXFHZcNRe8Wmj41RwunaJjIAwFLl/2Q9lUzfbn0.', //customer
                'is_admin' => 0
            ]
        ];
        User::insert($users_data);
    }
}
