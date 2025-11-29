<?php

namespace Tests\Feature;

use App\Models\ChangeRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setupClient(): array
    {
        $clientUser = User::factory()->client()->create();
        $client = Client::factory()->create();
        $client->users()->attach($clientUser);
        $project = Project::factory()->create(['client_id' => $client->id]);

        return [$clientUser, $client, $project];
    }

    public function test_client_can_access_portal_dashboard(): void
    {
        [$clientUser] = $this->setupClient();

        $response = $this->actingAs($clientUser)->get('/portal/dashboard');

        $response->assertStatus(200);
    }

    public function test_client_can_create_time_log(): void
    {
        [$clientUser, , $project] = $this->setupClient();

        $response = $this->actingAs($clientUser)->post(route('portal.time-logs.store'), [
            'project_id' => $project->id,
            'date' => now()->toDateString(),
            'hours' => 2.5,
            'description' => 'Development work',
        ]);

        $response->assertRedirect(route('portal.time-logs.index'));
        $this->assertDatabaseHas('time_logs', [
            'user_id' => $clientUser->id,
            'project_id' => $project->id,
            'approved' => false,
        ]);
    }

    public function test_client_can_submit_change_request(): void
    {
        [$clientUser, , $project] = $this->setupClient();

        $response = $this->actingAs($clientUser)->post(route('portal.change-requests.store'), [
            'project_id' => $project->id,
            'description' => 'Please add new feature flag.',
        ]);

        $response->assertRedirect(route('portal.change-requests.index'));
        $this->assertDatabaseHas('change_requests', [
            'requested_by' => $clientUser->id,
            'project_id' => $project->id,
        ]);
    }

    public function test_staff_can_approve_time_log(): void
    {
        [$clientUser, , $project] = $this->setupClient();
        $staff = User::factory()->staff()->create();
        $timeLog = TimeLog::factory()->create([
            'user_id' => $clientUser->id,
            'project_id' => $project->id,
            'approved' => false,
        ]);

        $response = $this->actingAs($staff)->put(route('admin.time-logs.update', $timeLog), [
            'approved' => true,
        ]);

        $response->assertRedirect();
        $this->assertTrue($timeLog->fresh()->approved);
    }

    public function test_staff_can_update_change_request_status(): void
    {
        [$clientUser, , $project] = $this->setupClient();
        $staff = User::factory()->staff()->create();
        $changeRequest = ChangeRequest::factory()->create([
            'project_id' => $project->id,
            'requested_by' => $clientUser->id,
            'status' => 'open',
        ]);

        $response = $this->actingAs($staff)->put(route('admin.change-requests.update', $changeRequest), [
            'status' => 'completed',
        ]);

        $response->assertRedirect();
        $this->assertEquals('completed', $changeRequest->fresh()->status);
    }

    public function test_client_cannot_access_other_clients_project(): void
    {
        [$clientUser, , ] = $this->setupClient();
        $otherClient = Client::factory()->create();
        $otherProject = Project::factory()->create(['client_id' => $otherClient->id]);

        $response = $this->actingAs($clientUser)->post(route('portal.time-logs.store'), [
            'project_id' => $otherProject->id,
            'date' => now()->toDateString(),
            'hours' => 1.5,
            'description' => 'Should fail',
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('time_logs', [
            'project_id' => $otherProject->id,
            'user_id' => $clientUser->id,
        ]);
    }
}
