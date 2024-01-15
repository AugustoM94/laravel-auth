<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = config('db.projects');
        foreach ($projects as $project) {
            $newproject = new Project();
            $newproject->image = $project['image'];
            $newproject->title = $project['title'];
            $newproject->link = $project['link'];
            $newproject->body = $project['body'];
            $newproject->user_id = 1;
            $newproject->slug = Str::slug($project['title'], '-');
            $newproject->save();
        }
    }
}
