<?php

namespace App\Events;

use App\Models\Project;

class ProjectClosed
{
    public Project $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
