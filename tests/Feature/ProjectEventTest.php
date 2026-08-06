<?php

use App\Events\MemberAddedToProject;
use App\Events\ProjectClosed;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Event;

it('dispatches a MemberAddedToProject event when a member is added to a project', function () {
    Event::fake();

    $owner = User::factory()->create();
    $member = User::factory()->create();
    $project = Project::factory()->create();

    $project->users()->attach($owner, ['role' => 'responsable']);

    $this->actingAs($owner)
        ->post(route('projects.members.store', ['project' => $project]), [
            'user_id' => $member->id,
            'role' => 'chercheur',
        ]);

    Event::assertDispatched(MemberAddedToProject::class, function (MemberAddedToProject $event) use ($project, $member) {
        return $event->project->is($project)
            && $event->member->is($member);
    });
});

it('dispatches a ProjectClosed event when a project is closed', function () {
    Event::fake();

    $owner = User::factory()->create();
    $project = Project::factory()->create(['status' => 'encours']);
    $project->users()->attach($owner, ['role' => 'responsable']);

    $this->actingAs($owner)
        ->post(route('projects.close', ['project' => $project]));

    Event::assertDispatched(ProjectClosed::class, function (ProjectClosed $event) use ($project) {
        return $event->project->is($project);
    });
});
