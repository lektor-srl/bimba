<?php

namespace Database\Seeders;

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
       \App\Models\Role::factory(1)->create();
       \App\Models\User::factory(1)->create();
       \App\Models\ArticlesTypes::factory()
           ->count(3)
           ->sequence(
               ['name' => 'progetto'],
               ['name' => 'credenziale'],
               ['name' => 'rapportino'],
           )
           ->create();

    }
}
