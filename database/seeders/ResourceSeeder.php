<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @var Resource $resourceOne
         * @var Resource $resourceTwo
         */
        $resourceOne = Resource::create();
        $resourceTwo = Resource::create();

        $resourceOne->bookings()->createMany([
            ['user_id' => '1'],
            ['user_id' => '1'],
        ]);

        $resourceTwo->bookings()->createMany([
            ['user_id' => '1'],
            ['user_id' => '1'],
        ]);
    }
}
