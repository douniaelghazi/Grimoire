<?php

use App\Http\Requests\StoreProjectRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('authorizes project creation for an authenticated user', function () {
    $user = User::factory()->create();

    $request = new StoreProjectRequest();
    $request->setUserResolver(fn () => $user);

    expect($request->authorize())->toBeTrue();
});
