<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Menyebarkan data logo dan banner ke seluruh view blade otomatis
        View::composer('*', function ($view) {
            $view->with('gWebsiteLogo', WebsiteSetting::get('website_logo'));
            $view->with('gHeroBanner', WebsiteSetting::get('hero_banner'));
            $view->with('gHeaderDesc', WebsiteSetting::get('header_description'));
        $view->with('gFooterDesc', WebsiteSetting::get('footer_description'));
            $view->with('gStoreName', WebsiteSetting::get('store_name', 'UMKMart'));
            $view->with('gFooterAddress', WebsiteSetting::get('footer_address'));
            $view->with('gFooterEmail', WebsiteSetting::get('footer_email'));
            $view->with('gFooterPhone', WebsiteSetting::get('footer_phone'));
            $view->with('gFooterOpenHours', WebsiteSetting::get('footer_open_hours'));
            $view->with('gHeroBackground', WebsiteSetting::get('hero_background'));
        });

        
    }
}