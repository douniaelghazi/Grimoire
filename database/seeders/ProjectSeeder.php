<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory(10)
    ->create()
    ->each(function ($project) {
        $project->users()->attach(
            rand(1, 10),
            ['role' => 'responsable']
        );
    });
    }
}