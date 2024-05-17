<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\Item;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Table;
use App\Models\User;
use App\Policies\Polices\AccountPolicy;
use App\Policies\Polices\CartPolicy;
use App\Policies\Polices\CustomerPolicy;
use App\Policies\Polices\FeedbackPolicy;
use App\Policies\Polices\ItemPolicy;
use App\Policies\Polices\MenuPolicy;
use App\Policies\Polices\ProductPolicy;
use App\Policies\Polices\ReviewPolicy;
use App\Policies\Polices\SliderPolicy;
use App\Policies\Polices\TablePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Menu::class => MenuPolicy::class,
        User::class => AccountPolicy::class,
        Feedback::class => FeedbackPolicy::class,
        Customer::class => CustomerPolicy::class,
        Item::class => ItemPolicy::class,
        Product::class => ProductPolicy::class,
        Review::class => ReviewPolicy::class,
        Slider::class => SliderPolicy::class,
        Table::class => TablePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
