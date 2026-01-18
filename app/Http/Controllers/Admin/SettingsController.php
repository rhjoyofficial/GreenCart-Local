<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'general' => $this->getGeneralSettings(),
            'payment' => $this->getPaymentSettings(),
            'shipping' => $this->getShippingSettings(),
            'notifications' => $this->getNotificationSettings(),
            'seo' => $this->getSeoSettings(),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $section = $request->section;

        switch ($section) {
            case 'general':
                return $this->updateGeneralSettings($request);
            case 'payment':
                return $this->updatePaymentSettings($request);
            case 'shipping':
                return $this->updateShippingSettings($request);
            case 'notifications':
                return $this->updateNotificationSettings($request);
            case 'seo':
                return $this->updateSeoSettings($request);
            default:
                return back()->with('error', 'Invalid settings section.');
        }
    }

    private function getGeneralSettings()
    {
        return [
            'site_name' => config('app.name', 'Multi-Vendor Store'),
            'site_email' => config('mail.from.address', 'admin@example.com'),
            'site_phone' => Cache::get('settings.site_phone', '+8801234567890'),
            'site_address' => Cache::get('settings.site_address', ''),
            'site_currency' => Cache::get('settings.site_currency', 'BDT'),
            'site_timezone' => config('app.timezone', 'Asia/Dhaka'),
            'maintenance_mode' => Cache::get('settings.maintenance_mode', false),
        ];
    }

    private function getPaymentSettings()
    {
        return [
            'default_gateway' => Cache::get('settings.payment.default_gateway', 'cash'),
            'sslcommerz_store_id' => Cache::get('settings.payment.sslcommerz_store_id', ''),
            'sslcommerz_store_password' => Cache::get('settings.payment.sslcommerz_store_password', ''),
            'sslcommerz_mode' => Cache::get('settings.payment.sslcommerz_mode', 'sandbox'),
            'bkash_app_key' => Cache::get('settings.payment.bkash_app_key', ''),
            'bkash_app_secret' => Cache::get('settings.payment.bkash_app_secret', ''),
            'enable_cod' => Cache::get('settings.payment.enable_cod', true),
        ];
    }

    private function getShippingSettings()
    {
        return [
            'default_shipping_method' => Cache::get('settings.shipping.default_method', 'standard'),
            'standard_shipping_cost' => Cache::get('settings.shipping.standard_cost', 50),
            'express_shipping_cost' => Cache::get('settings.shipping.express_cost', 100),
            'free_shipping_threshold' => Cache::get('settings.shipping.free_threshold', 2000),
            'enable_tracking' => Cache::get('settings.shipping.enable_tracking', true),
        ];
    }

    private function getNotificationSettings()
    {
        return [
            'email_order_confirmation' => Cache::get('settings.notifications.email_order_confirmation', true),
            'email_shipping_update' => Cache::get('settings.notifications.email_shipping_update', true),
            'email_product_approval' => Cache::get('settings.notifications.email_product_approval', true),
            'sms_order_confirmation' => Cache::get('settings.notifications.sms_order_confirmation', false),
            'sms_shipping_update' => Cache::get('settings.notifications.sms_shipping_update', false),
            'admin_email' => Cache::get('settings.notifications.admin_email', 'admin@example.com'),
        ];
    }

    private function getSeoSettings()
    {
        return [
            'meta_title' => Cache::get('settings.seo.meta_title', 'Multi-Vendor E-Commerce'),
            'meta_description' => Cache::get('settings.seo.meta_description', ''),
            'meta_keywords' => Cache::get('settings.seo.meta_keywords', ''),
            'google_analytics_id' => Cache::get('settings.seo.google_analytics_id', ''),
            'facebook_pixel_id' => Cache::get('settings.seo.facebook_pixel_id', ''),
        ];
    }

    private function updateGeneralSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_email' => 'required|email',
            'site_phone' => 'nullable|string|max:30',
            'site_address' => 'nullable|string',
            'site_currency' => 'required|string|max:10',
            'maintenance_mode' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever("settings.$key", $value);
        }

        return back()->with('success', 'General settings updated successfully.');
    }

    private function updatePaymentSettings(Request $request)
    {
        $validated = $request->validate([
            'default_gateway' => 'required|in:cash,sslcommerz,bkash',
            'sslcommerz_store_id' => 'nullable|string',
            'sslcommerz_store_password' => 'nullable|string',
            'sslcommerz_mode' => 'required|in:sandbox,live',
            'bkash_app_key' => 'nullable|string',
            'bkash_app_secret' => 'nullable|string',
            'enable_cod' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever("settings.payment.$key", $value);
        }

        return back()->with('success', 'Payment settings updated successfully.');
    }

    private function updateShippingSettings(Request $request)
    {
        $validated = $request->validate([
            'default_shipping_method' => 'required|in:standard,express',
            'standard_shipping_cost' => 'required|numeric|min:0',
            'express_shipping_cost' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'enable_tracking' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever("settings.shipping.$key", $value);
        }

        return back()->with('success', 'Shipping settings updated successfully.');
    }

    private function updateNotificationSettings(Request $request)
    {
        $validated = $request->validate([
            'email_order_confirmation' => 'boolean',
            'email_shipping_update' => 'boolean',
            'email_product_approval' => 'boolean',
            'sms_order_confirmation' => 'boolean',
            'sms_shipping_update' => 'boolean',
            'admin_email' => 'required|email',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever("settings.notifications.$key", $value);
        }

        return back()->with('success', 'Notification settings updated successfully.');
    }

    private function updateSeoSettings(Request $request)
    {
        $validated = $request->validate([
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'google_analytics_id' => 'nullable|string',
            'facebook_pixel_id' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever("settings.seo.$key", $value);
        }

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
