<?php

namespace Database\Seeders;

use App\Enums\ProfileType;
use App\User;
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
        User::factory()->create([
            'first_name'    => 'root',
            'last_name'     => 'root',
            'email'         => 'root@root.com',
            'password'      => bcrypt('root1234'),
            'profile'       => ProfileType::ADMIN,
            'date_of_birth' => '01/01/1990'
        ]);

        User::factory(10)->create();
    }
}
