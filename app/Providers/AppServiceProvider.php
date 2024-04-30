<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Map full class names to simple identifier
        // for simplification of polymorphic relation
        Relation::enforceMorphMap([
            'company' => 'App\Models\Company',
            'contact' => 'App\Models\Contact',
            'customer' => 'App\Models\Customer',
            'lead' => 'App\Models\Lead',
            'sale' => 'App\Models\Sale',
            'user' => 'App\Models\User',
        ]);
    }
}
