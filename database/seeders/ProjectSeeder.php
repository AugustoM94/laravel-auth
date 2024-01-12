<?php

namespace Database\Seeders;

use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $newProject = new Project();
            $newProject->image = $faker->imageUrl(640, 480, 'sites', true);
            $newProject->title = $faker->unique()->slug(3);
            $newProject->body = $faker->paragraph();
            $newProject->link = $faker->url();
            $newProject->user_id = 1;
            $newProject->slug = $newProject->title;
            $newProject->slug = $newProject->id.'-'.$newProject->title;
            $newProject->save();
        }
    }
}
