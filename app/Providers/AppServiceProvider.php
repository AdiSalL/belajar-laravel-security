<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Todo;
use App\Models\User;
use App\Policies\TodoPolicy;
use App\Policies\UserPolicy;
use App\Providers\Guard\TokenGuard;
use App\Providers\User\SimpleProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    protected $policies = [
        User::class => UserPolicy::class,
        Todo::class => TodoPolicy::class
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Auth::extend("token", function(FoundationApplication $app, string $name, array $config) {
            $tokenGuard = new TokenGuard(Auth::createUserProvider($config["provider"]) , $app->make(Request::class));
            $app->refresh("request", $tokenGuard, "setRequest");
            return $tokenGuard;
        });

        Auth::provider("simple", function (FoundationApplication $app, array $config) {
            return new SimpleProvider();
        });

        Gate::define("get-contact", function(User $user, Contact $contact) {
                return $user->id == $contact->user_id;
        });

        Gate::define("update-contact", function(User $user, Contact $contact) {
            return $user->id == $contact->user_id;
        });

        Gate::define("delete-contact", function(User $user, Contact $contact) {
        return $user->id == $contact->user_id;
        });

        Gate::define("create-contact", function (User $user) {
            if($user->name == "admin") {
                return Response::allow();
            }else {
                return Response::deny("You'are Not Admin");
            }
        });
    }
}
