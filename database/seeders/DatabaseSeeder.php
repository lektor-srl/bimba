<?php

namespace Database\Seeders;

use App\Models\ArticlesTypes;
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
               ['id' => ArticlesTypes::TYPEPROGETTO , 'name' => 'progetto'],
               ['id' => ArticlesTypes::TYPECREDENZIALE , 'name' => 'credenziale'],
               ['id' => ArticlesTypes::TYPERAPPORTINO , 'name' => 'rapportino'],
           )
           ->create();

    }
}
