<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderSubscription;
use App\Models\PhoneNumber;
use App\Policies\OrderPolicy;
use App\Policies\PhoneNumberPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Order::class=>OrderPolicy::class,
        PhoneNumber::class =>PhoneNumberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
