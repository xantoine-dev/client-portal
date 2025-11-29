<?php

namespace Database\Seeders;

use App\Models\ChangeRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $staff = User::factory()->staff()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);

        $clientUser = User::factory()->client()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
        ]);

        $client = Client::factory()->create([
            'name' => 'Acme Corp',
            'contact_email' => 'client@example.com',
            'notes' => 'Sample client record seeded for portal.',
        ]);

        $client->users()->attach($clientUser->id);

        $project = Project::factory()->create([
            'client_id' => $client->id,
            'name' => 'Website Redesign',
            'status' => 'active',
        ]);

        TimeLog::factory()->count(2)->create([
            'project_id' => $project->id,
            'user_id' => $clientUser->id,
            'approved' => false,
        ]);

        TimeLog::factory()->create([
            'project_id' => $project->id,
            'user_id' => $clientUser->id,
            'approved' => true,
            'approved_by' => $staff->id,
            'description' => 'Initial design review and feedback collection.',
        ]);

        ChangeRequest::factory()->create([
            'project_id' => $project->id,
            'requested_by' => $clientUser->id,
            'status' => 'open',
            'description' => 'Add analytics tracking to landing page.',
        ]);

        ChangeRequest::factory()->create([
            'project_id' => $project->id,
            'requested_by' => $clientUser->id,
            'status' => 'in_review',
            'description' => 'Update hero copy for new product messaging.',
        ]);
    }
}
