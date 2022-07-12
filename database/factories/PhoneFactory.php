<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $devices = [
            'Cisco 8865' => [
                'class' => 'Phone',
                'protocol' => 'SIP'
            ],
            'Cisco 8851' => [
                'class' => 'Phone',
                'protocol' => 'SIP'
            ],
            'Cisco 8811' => [
                'class' => 'Phone',
                'protocol' => 'SIP'
            ],
            'Cisco 7965' => [
                'class' => 'Phone',
                'protocol' => 'SCCP'
            ],
            'Cisco 7945' => [
                'class' => 'Phone',
                'protocol' => 'SCCP'
            ],
            'Jabber for Windows' => [
                'class' => 'Phone',
                'protocol' => 'SIP'
            ],
            'Jabber for iPhone' => [
                'class' => 'Phone',
                'protocol' => 'SIP'
            ],
        ];

        $device = array_rand($devices);

        return [
            'pkid' => $this->faker->uuid(),
            'name' => "SEP" . str_replace(':', '', $this->faker->macAddress()),
            'model' => $device,
            'class' => $devices[$device]['class'],
            'status' => $this->faker->randomElement([
                'Registered',
                'PartiallyRegistered',
                'UnRegistered',
                'Rejected',
                'Unknown'
            ]),
            'protocol' => $devices[$device]['protocol'],
            'ipAddress' => $this->faker->localIpv4(),
            'activeLoad' => '8.1.3',
            'inactiveLoad' => '8.0.1',
        ];
    }
}
