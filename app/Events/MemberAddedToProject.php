<?php

namespace App\Events;

use App\Models\Project;
use App\Models\User;

class MemberAddedToProject
{
    public Project $project;
    public User $member;

    public function __construct(Project $project, User $member)
    {
        $this->project = $project;
        $this->member = $member;
    }
}
