<?php

use App\Enums\ProfileType;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'    => 'root',
            'last_name'     => 'root',
            'email'         => 'root@root.com',
            'password'      => bcrypt('root1234'),
            'profile'       => ProfileType::ADMIN,
            'date_of_birth' => '1990-01-01'
        ]);
    }
}