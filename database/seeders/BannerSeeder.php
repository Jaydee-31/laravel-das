<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            'acmp-dashboard-banner',
            'email-banner',
            'external-display-banner',
            'shop-basket-banner',
            'shop-compare-banner',
            'shop-daily-news',
            'shop-dashboard',
            'shop-dashboard-mega',
            'shop-dashboard-super',
            'shop-footer-banner',
            'shop-layer-banner',
            'shop-notepad-banner',
            'shop-order-confirmation-banner',
            'shop-popup-banner',
            'shop-product-detail',
            'social-banner',
            'today-email-special-banner',
            'today-email-topbanner',
            'website-deals&discoveries-banner',
            'website-deals&discoveries-teaser-image',
            'website-deals&discoveries-hero-image',
            'website-homepage-banner',
            'website-otherpage-banner',
        ];

        $sizes = [
            '300x250',
            '300x600',
            '320x50',
            '728x90',
            '970x250',
            '510x170',
            '1200x628'
        ];

        foreach ($banners as $banner) {
            Banner::create([
                'name' => $banner,
                'sizes' => $sizes
            ]);
        }
    }
}
