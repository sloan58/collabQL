<?php

namespace Database\Seeders;

use App\Models\Ucm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
         \App\Models\User::factory(10)->create();

         foreach(config('states') as $abbr => $state) {
             $state = str_replace(' ', '-', $state);
             $state = strtolower($state);
             Ucm::factory()->create(
                 [ 'name' => sprintf('ucm-%s-cluster', $state) ]
             )->each(function($ucm) {

             });
         }
    }
}
