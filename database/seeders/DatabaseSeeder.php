<?php

namespace Database\Seeders;

use App\Models\Ucm;
use App\Models\User;
use App\Models\Phone;
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
         $states = config('states');

         foreach($states as $abbr => $state) {
             $clusterUsers = User::factory(20)->raw();
             $eloquentUsers = collect();

             $state = str_replace(' ', '-', $state);
             $state = strtolower($state);

             $ucm = Ucm::factory()->create(
                 [ 'name' => sprintf('ucm-%s-cluster', $state) ]
             );

             foreach($clusterUsers as $clusterUser) {
                 $newUser = User::create($clusterUser);
                 $eloquentUsers->push($newUser);
                 $spTypes = [
                     'executive',
                     'manager',
                     'employee'
                 ];
                 $spName = sprintf('%s-%s-sp', strtolower($abbr), $spTypes[rand(0,2)]);
                 $newUser->ucms()->attach($ucm, [
                     'pkid' => uniqid(),
                     'userid' => $newUser->name,
                     'homeCluster' => true,
                     'serviceProfile' => $spName
                 ]);
             }

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
                     'name' => sprintf('%s-%s_DP', $abbr, $type)
                 ]);
             }


             $stateCode = str_pad(array_search($abbr, $states) + 1, 2, 0);
             $jobRoles = [
                 'Accounting',
                 'Human Resources',
                 'Technical Support',
                 'Logistics',
                 'Executive Assistant',
                 'Vice President',
                 'President',
                 'Contractor',
                 'Marketing',
                 'Sales'
             ];


             foreach ($eloquentUsers as $index => $user) {
                 $internalExtension = sprintf('8%s10%s', (string) $stateCode, str_pad($index, 2, STR_PAD_LEFT));
                 $fullDID = sprintf('+15555%s', substr($internalExtension, -6));
                 $jobRole = $jobRoles[array_rand($jobRoles)];
                 $line = $ucm->lines()->create([
                     'pkid' => uniqid(),
                     'pattern' => $internalExtension,
                     'description' => sprintf('%s-%s-%s', $fullDID, $user->name, $jobRole),
                     'patternUsage' => 'Device',
                     'partition_id' => Partition::where(
                         'name',
                         sprintf("%s-INTERNAL_PT", strtoupper($abbr))
                     )->first()->id
                 ]);

                 $phoneDescription = sprintf('%s-%s-%s', $abbr, $user->name, $jobRole);

                 $phone = Phone::factory()->raw([
                     'description' => $phoneDescription,
                     'ucm_id' => $ucm->id,
                     'device_pool_id' => $ucm->devicePools()->where('name', 'like', '%PHONE%')->first()->id,
                     'calling_search_space_id' => $ucm->callingSearchSpaces()->first()->id
                 ]);

                 $phone = Phone::create($phone);
                 $phone->lines()->attach($line, [
                     'pkid' => uniqid(),
                    'numplanindex' => '1',
                    'ucm_id' => $ucm->id
                 ]);
             }
         }
    }
}
