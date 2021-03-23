<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('view-invoice', function (User $user, Invoice $invoice) { //callback function, user is authenticated user
        //     return $user->email === $invoice->customer->email; //if not equal, will deny
        // });

        //for every policy
        Gate::before(function (User $user) //called before other authorization methods (there is also an after())
        {
            //return $user->isAdmin() won't work because would return false if not admin (possible return values are true or false)
            //false causes all other policies to be skipped

            // 2 possible return values are true or NULL (null allows execution of further policies)
            if ($user->isAdmin()) { //if user is admin, don't need to check other methods
                return true;
            }
            //skips all other policy methods if returns true
        });

        //
    }
}
