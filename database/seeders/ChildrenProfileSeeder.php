<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildrenProfile;

class ChildrenProfileSeeder extends Seeder
{
    public function run()
    {
        ChildrenProfile::create([
            'parent_id' => 2, 
            'name' => 'John Doe',
            'profile_photo' => 'john.jpg',
            'cover_photo' => 'john_cover.jpg',
            'date_of_birth' => '2016-03-15',
            'hobbies' => json_encode(['Drawing', 'Cycling']),
            'dream_career' => 'Astronaut',
        ]);

        ChildrenProfile::create([
            'parent_id' => 3, 
            'name' => 'Jane Smith',
            'profile_photo' => 'jane.jpg',
            'cover_photo' => 'jane_cover.jpg',
            'date_of_birth' => '2014-07-20',
            'hobbies' => json_encode(['Swimming', 'Reading']),
            'dream_career' => 'Doctor',
        ]);

        ChildrenProfile::create([
            'parent_id' => 5, 
            'name' => 'Jana Maddah',
            'profile_photo' => null,
            'cover_photo' => null,
            'date_of_birth' => '2020-03-15',
            'hobbies' => json_encode(['Drawing', 'Math']),
            'dream_career' => 'Astronaut',
        ]);
    }
}
