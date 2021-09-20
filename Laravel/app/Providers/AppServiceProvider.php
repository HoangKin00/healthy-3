<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer("*", function($view){
        $acc_id=Auth::guard('customer')->id();
            if(!Auth::guard('customer')->check()){
                $tt=0;
            }else{
                $ttq = Cart::where('customer_id',$acc_id)->get();
                $tt=0;
                foreach($ttq as $key => $item){
                    $tt += $item['quantity'];
                }
            }
            $count = Favorite::where('customer_id',$acc_id)->count();
            $view->with(compact('tt','count'));
        });
    }
}
