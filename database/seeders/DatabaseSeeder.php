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
         User::factory(1000)->create();
         $users = User::all();

         $states = config('states');

         foreach($states as $abbr => $state) {
             $totalUsers = User::count();
             $stateArrayIndex = array_search($abbr, array_keys($states));
             $statesCount = count($states);

             $clusterUsers = $users->slice($stateArrayIndex, $totalUsers / $statesCount);

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


             $stateCode = str_pad($stateArrayIndex + 1, 2, 0);
             $jobRoles = [
                 'Accounting',
                 'Human Resources',
                 'Technical Support',
                 'Logistics',
                 'Executive Staff'
             ];

             foreach(range(1000, 1500) as $lastFour) {
                 $internalExtension = sprintf('8%s%s', (string) $stateCode, $lastFour);
                 $fullDID = sprintf('5555%s', substr($internalExtension, -6));
                 $ucm->lines()->create([
                     'pkid' => uniqid(),
                     'pattern' => $internalExtension,
                     'description' => sprintf('+1%s-%s-%s', $fullDID, fake()->name(), $jobRoles[array_rand($jobRoles)]),
                     'patternUsage' => 'Device',
                     'partition_id' => Partition::where(
                         'name',
                         sprintf("%s-INTERNAL_PT", strtoupper($abbr))
                     )->first()->id
                 ]);
             }
         }
    }
}
