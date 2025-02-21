<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Post;
use App\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class, // Map Post model to PostPolicy
    ];

    public function boot()
    {
        $this->registerPolicies(); // Critical for policy registration
    }
}