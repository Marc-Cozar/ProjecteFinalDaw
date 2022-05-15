<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create(['name' => 'Marc', 'surname' => 'Cozar', 'email' => 'marc@gmail.com', 'role_id' => 1, 'password' => bcrypt('marc1234')]);
    }
}
