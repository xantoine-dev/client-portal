<?php

namespace App\Providers;

use App\Models\ChangeRequest;
use App\Models\TimeLog;
use App\Policies\ChangeRequestPolicy;
use App\Policies\TimeLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        TimeLog::class => TimeLogPolicy::class,
        ChangeRequest::class => ChangeRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
