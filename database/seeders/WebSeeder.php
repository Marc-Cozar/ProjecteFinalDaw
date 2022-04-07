<?php

namespace Database\Seeders;

use App\Models\Web;
use Illuminate\Database\Seeder;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Web::create(['name' => 'PcComponentes', 'url' => 'www.pccomponentes.com']);
        Web::create(['name' => 'CoolMod', 'url' => 'www.coolmod.com']);
        Web::create(['name' => 'Amazon', 'url' => 'www.amazon.com']);
        Web::create(['name' => 'PcBox', 'url' => 'www.pcbox.com']);
    }
}