<?php

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
            'name'      => 'root',
            'email'     => 'root@root.com',
            'password'  => bcrypt('root1234'),
            'profile'   => 'admin',
            'birth'     => '1990-01-01'
        ]);
    }
}