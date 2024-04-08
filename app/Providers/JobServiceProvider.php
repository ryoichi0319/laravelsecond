<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jobs\SampleJob;
class JobServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindMethod(SampleJob::class.'@handle', function($job, $app) {
            return $job->handle();
        });
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
