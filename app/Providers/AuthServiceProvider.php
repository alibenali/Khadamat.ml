<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Balance' => 'App\Policies\BalancePolicy',
        'App\Deposit' => 'App\Policies\DepositPolicy',
        'App\Service' => 'App\Policies\ServicePolicy',
        'App\Conversation' => 'App\Policies\ConversationPolicy',
        'App\Payment' => 'App\Policies\PaymentPolicy',
        'App\Profile' => 'App\Policies\ProfilePolicy',
        'App\User' => 'App\Policies\ProfilePolicy',
        'App\Withdraw' => 'App\Policies\WithdrawPolicy',
        'App\Payments_offer' => 'App\Policies\OfferPolicy',
        'App\Message' => 'App\Policies\messagePolicy',
        'App\Rating' => 'App\Policies\RatingPolicy',
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
