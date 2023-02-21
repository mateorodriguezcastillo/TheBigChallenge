<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_submissions(): void
    {
        Submission::factory()->count(20)->create();
        $user = User::first();
        $response = $this->actingAs($user)->getJson(route('submission.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(15, 'data');
    }

    public function test_get_all_submissions_with_pagination(): void
    {
        Submission::factory()->count(20)->create();
        $user = User::first();
        $response = $this->actingAs($user)->getJson(route('submission.index', ['page' => 2]));
        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

    public function test_get_all_submissions_with_filter(): void
    {
        Submission::factory()->count(5)->create(['status' => 'pending']);
        Submission::factory()->count(5)->create(['status' => 'in_progress']);
        Submission::factory()->count(5)->create(['status' => 'done']);
        $user = User::first();
        $response = $this->actingAs($user)->getJson(route('submission.index', ['status' => 'pending']));
        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }
}
