<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Post;
use App\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    use App\Policies\PostPolicy;

    protected $policies = [
        Post::class => PostPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies(); // Critical for policy registration
    }
}
