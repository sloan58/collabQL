<?php

namespace Database\Seeders;

use App\Models\Ucm;
use App\Models\User;
use App\Models\Partition;
use App\Models\DevicePool;
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
                 $spName = sprintf('%s-%s-sp', strtolower($abbr), $spTypes[rand(0,2)]);
                 $user->ucms()->attach($ucm, [
                     'pkid' => uniqid(),
                     'userid' => $user->name,
                     'homeCluster' => $isHomeCluster,
                     'serviceProfile' => $isHomeCluster ? $spName : ''
                 ]);
             });

             $abilities = ['INTERNAL', 'LOCAL', 'LONG-DISTANCE', 'INTERNATIONAL'];

             foreach($abilities as $ability) {
                 $ucm->partitions()->create([
                     'pkid' => uniqid(),
                     'name' => sprintf("%s-%s_PT", strtoupper($abbr), $ability),
                     'description' => sprintf(
                         "%s %s Partition",
                         ucfirst($state),
                         ucwords(strtolower(str_replace("-", " ", $ability)))
                     ),
                 ]);
             }

             foreach($abilities as $key => $ability) {
                 $css = $ucm->callingSearchSpaces()->create([
                     'pkid' => uniqid(),
                     'name' => sprintf("%s-%s_CSS", strtoupper($abbr), $ability),
                     'description' => sprintf(
                         "%s %s Calling Search Space",
                         ucfirst($state),
                         ucwords(strtolower(str_replace("-", " ", $ability)))
                     ),
                 ]);

                 foreach(array_slice($abilities, 0, $key + 1) as $innerKey => $partitionAbility) {
                     $css->partitions()->attach(
                         Partition::where([
                             'ucm_id' => $ucm->id,
                             'name' => sprintf("%s-%s_PT", strtoupper($abbr), $partitionAbility),
                         ])->first(), [
                             'index' => $innerKey + 1
                         ]
                     );
                 }
             }

             foreach(['TRUNK', 'PHONE', 'GATEWAY'] as $type) {
                 $ucm->devicePools()->create([
                     'pkid' => uniqid(),
                     'name' => sprintf('%s-%s_DP', $state, $type)
                 ]);
             }
         }
    }
}
