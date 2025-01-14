<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildrenProfile;

class ChildrenProfileSeeder extends Seeder
{
    public function run()
    {
        ChildrenProfile::create([
            'parent_id' => 2, // Parent1 ID
            'name' => 'John Doe',
            'age' => 7,
            'profile_photo' => 'john.jpg',
            'cover_photo' => 'john_cover.jpg',
        ]);

        ChildrenProfile::create([
            'parent_id' => 3, // Parent2 ID
            'name' => 'Jane Smith',
            'age' => 9,
            'profile_photo' => 'jane.jpg',
            'cover_photo' => 'jane_cover.jpg',
        ]);
    }
}
