<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildrenProfile;

class ChildrenProfileSeeder extends Seeder
{
    public function run()
    {
        ChildrenProfile::create([
            'user_id' => 2, 
            'name' => 'John Doe',
            'date_of_birth' => '2016-03-15',
            'hobbies' => json_encode(['Drawing', 'Cycling']),
            'dream_job' => 'Astronaut',
        ]);

        ChildrenProfile::create([
            'user_id' => 3, 
            'name' => 'Jane Smith',
            'date_of_birth' => '2014-07-20',
            'hobbies' => json_encode(['Swimming', 'Reading']),
            'dream_job' => 'Doctor',
        ]);

        ChildrenProfile::create([
            'user_id' => 4, 
            'name' => 'Jana Maddah',
            'date_of_birth' => '2020-03-15',
            'hobbies' => json_encode(['Drawing', 'Math']),
            'dream_job' => 'Astronaut',
        ]);
    }
}
