<?php

namespace Database\Seeders;

use App\Models\Ucm;
use App\Models\User;
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
         \App\Models\User::factory(1000)->create();

         foreach(config('states') as $abbr => $state) {
             $state = str_replace(' ', '-', $state);
             $state = strtolower($state);

             $ucm = Ucm::factory()->create(
                 [ 'name' => sprintf('ucm-%s-cluster', $state) ]
             );

             User::each(function($user) use ($abbr, $state, $ucm) {
                 $homeCluster = array_rand(config('states'));
                 $isHomeCluster = $abbr === $homeCluster;
                 $spTypes = [
                     'executive',
                     'manager',
                     'employee'
                 ];
                 $spName = sprintf('%s-%s-sp', $abbr, $spTypes[rand(0,2)]);
                 $user->ucms()->attach($ucm, [
                     'pkid' => uniqid(),
                     'userid' => $user->name,
                     'homeCluster' => $isHomeCluster,
                     'serviceProfile' => $isHomeCluster ? $spName : ''
                 ]);
             });
         }
    }
}
