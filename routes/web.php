<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    AdminAuthController,
    VendorAuthController,
    ItemListController,
    OnboardingController
};
use App\Http\Controllers\Admin\{
    MenuController,
    MenuCategoryController,
    VendorController,
    SubscriptionController,
    VendorSubscriptionController,
    TicketsController,
    VendorMenuRequestController
};
use App\Http\Controllers\Vendor\{
    VendorMenuController,
    VendorMenuSetupController,
    VendorSettingController,
    VendorDiningOrderController,
    NotificationController,
    TicketController,
    MenuRequestController,
    InvoiceController,
    VendorCategoryController
};
use App\Http\Controllers\ContactController;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared successfully!";
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/vendor/onboarding', [OnboardingController::class, 'index'])->name('vendor.onboarding');
Route::post('/vendor/store', [OnboardingController::class, 'store'])->name('vendor.store');

Route::prefix('admin')->name('admin.')->middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
    
    // Menu routes for admin
    Route::get('menus', [MenuController::class, 'index'])->name('menus');
    Route::get('menus/data', [MenuController::class, 'getMenusData'])->name('menus.data');
    Route::get('menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Categories routes for admin
    Route::get('menu-categories', [MenuCategoryController::class, 'index'])->name('menu-categories');
    Route::get('menu-categories/data', [MenuCategoryController::class, 'getMenuCategoryData'])->name('menucategory.data');
    Route::get('menu-categories/create', [MenuCategoryController::class, 'create'])->name('menu_categories.create');
    Route::post('menu-categories/store', [MenuCategoryController::class, 'store'])->name('menu-categories.store');
    Route::get('menu-categories/{id}/edit', [MenuCategoryController::class, 'edit'])->name('menu_categories.edit');
    Route::put('menu-categories/{id}', [MenuCategoryController::class, 'update'])->name('menu-categories.update');
    Route::delete('menu-categories/{id}', [MenuCategoryController::class, 'destroy'])->name('menu_categories.destroy');

    // Vendor routes for admin
    Route::get('vendors', [VendorController::class, 'index'])->name('vendors');
    Route::get('vendors/data', [VendorController::class, 'getVendorsData'])->name('vendors.data');
    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
    Route::put('vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');

    Route::post('vendors_subscriptions', [VendorSubscriptionController::class, 'store'])->name('vendors_subscriptions.store');

    // Subscription routes for admin
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
    Route::get('subscriptions/data', [SubscriptionController::class, 'getSubscriptionsData'])->name('subscriptions.data');
    Route::get('subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    
    
    Route::post('vendors_subscriptions', [VendorSubscriptionController::class, 'store'])->name('vendors_subscriptions.store');
    
    Route::get('tickets', [TicketsController::class, 'index'])->name('tickets.index');
    Route::get('getTicketData', [TicketsController::class, 'getTicketData'])->name('tickets.list');
    Route::post('updateTicketStatus', [TicketsController::class, 'updateTicketStatus'])->name('tickets.update-status');

    Route::get('menu-request', [VendorMenuRequestController::class, 'index'])->name('menu-request.index');
    Route::get('getMenuRequest', [VendorMenuRequestController::class, 'getMenuRequestData'])->name('menu-request.list');
    Route::post('updateMenuRequestStatus', [VendorMenuRequestController::class, 'updateMenuRequestStatus'])->name('menu-request.update-status');
});

Route::view('/', 'index');
Route::view('pricing', 'pricing');
Route::view('digital-menu', 'digital-menu');
Route::view('qr-code-menu', 'qr-code-menu');
Route::view('admin-dashboard', 'admin-dashboard');
Route::view('terms-and-conditions', 'terms-and-conditions');
Route::view('privacy-policy', 'privacy-policy');
Route::view('contact-us', 'contact')->name('contact');
Route::view('about-us', 'about')->name('about-us');
Route::view('careers', 'careers')->name('careers');
Route::any('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::prefix('vendor')->group(function () {
    Route::get('/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
    Route::any('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');
    
    Route::middleware('auth:vendor')->group(function () {
       
        Route::get('/dashboard', [VendorAuthController::class, 'dashboard'])->name('vendor.dashboard');
        
        Route::get('menus', [VendorMenuController::class, 'index'])->name('vendor.menus');
        Route::get('menus/data', [VendorMenuController::class, 'getMenusData'])->name('vendor.menus.data');
        Route::get('menus/create', [VendorMenuController::class, 'create'])->name('vendor.menus.create');
        Route::post('menus', [VendorMenuController::class, 'store'])->name('vendor.menus.store');
        Route::get('menus/{menu}/edit', [VendorMenuController::class, 'edit'])->name('vendor.menus.edit');
        Route::put('menus/{menu}', [VendorMenuController::class, 'update'])->name('vendor.menus.update');
        Route::delete('menus/{menu}', [VendorMenuController::class, 'destroy'])->name('vendor.menus.destroy');
        Route::post('menus/update-status', [VendorMenuController::class, 'updateStatus'])->name('vendor.menus.updateStatus');
        Route::get('menus/clone-menu', [VendorMenuController::class, 'clone'])->name('vendor.menus.clone');

        Route::get('categories', [VendorCategoryController::class, 'index'])->name('vendor.categories.index');
        Route::get('categories/create', [VendorCategoryController::class, 'create'])->name('vendor.categories.create');
        Route::get('categories/{category}/edit', [VendorCategoryController::class, 'edit'])->name('vendor.categories.edit');
        Route::get('categories/data', [VendorCategoryController::class, 'data'])->name('vendor.categories.data');
        Route::post('categories', [VendorCategoryController::class, 'store'])->name('vendor.categories.store');
        Route::put('categories/{category}', [VendorCategoryController::class, 'update'])->name('vendor.categories.update');
        Route::delete('categories/{category}', [VendorCategoryController::class, 'destroy'])->name('vendor.categories.destroy');


        Route::get('menus/getByCategory', [VendorMenuController::class, 'getMenusByCategory'])->name('vendor.menus.getByCategory');
        Route::post('menus/add', [VendorMenuController::class, 'addMenuToVendor'])->name('vendor.menus.add');
        Route::get('menus/menus-setup', [VendorMenuSetupController::class, 'index'])->name('vendor.menu.setup');
        Route::post('menus/save', [VendorMenuSetupController::class, 'storeOrUpdate'])->name('vendor.menu.save');
        Route::get('menus/get-discount', [VendorMenuSetupController::class, 'getDiscount'])->name('vendor.get.discount');
        
        Route::get('settings', [VendorSettingController::class, 'index'])->name('vendor.settings.index');
        Route::any('settings/save', [VendorSettingController::class, 'saveOrUpdate'])->name('vendor.settings.saveOrUpdate');
        Route::get('/settings/qrcode-customize', [VendorSettingController::class, 'customizeQrcode'])->name('vendor.settings.qrcodecustomize');
        Route::get('/get-states-by-country', [VendorSettingController::class, 'getStatesByCountryName'])->name('getStatesByCountryName');
        Route::any('settings/change-password', [VendorSettingController::class, 'changepassword'])->name('vendor.settings.change-password');
        Route::post('/settings/update-password', [VendorSettingController::class, 'updatePassword'])->name('vendor.settings.update-password');
        
        Route::get('settings/socialmedia', [VendorSettingController::class, 'socialmedia'])->name('vendor.settings.socialmedia');
        Route::any('settings/savesocialmedia', [VendorSettingController::class, 'saveOrUpdateSocialMedia'])->name('vendor.settings.saveOrUpdateSocialMedia');
        
        Route::post('update-profile', [VendorSettingController::class, 'updateProfile'])->name('vendor.setting.update-profile');

        Route::get('dining-orders', [VendorDiningOrderController::class, 'index'])->name('vendor.dining-orders.index');
        Route::post('/vendor/dining-orders/updateStatus', [VendorDiningOrderController::class, 'updateStatus'])->name('vendor.dining-orders.updateStatus');
        
        Route::get('/notifications', [NotificationController::class, 'index'])->name('vendor.notifications.index');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('vendor.notifications.markAsRead');
        

        Route::get('tickets', [TicketController::class, 'index'])->name('vendor.tickets.index');
        Route::get('tickets/list', [TicketController::class, 'getTicketData'])->name('vendor.tickets.list');
        Route::get('tickets/create', [TicketController::class, 'create'])->name('vendor.tickets.create');
        Route::post('tickets/store', [TicketController::class, 'store'])->name('vendor.tickets.store');
        // Route::get('tickets/edit/{id}', [TicketController::class, 'edit'])->name('vendor.tickets.edit');
        Route::post('tickets/destroy/{id}', [TicketController::class, 'destroy'])->name('vendor.tickets.destroy');

        Route::get('menu-request', [MenuRequestController::class, 'index'])->name('vendor.menu-request.index');
        Route::get('menu-request/list', [MenuRequestController::class, 'getMenuRequestData'])->name('vendor.menu-request.list');
        Route::get('menu-request/create', [MenuRequestController::class, 'create'])->name('vendor.menu-request.create');
        Route::post('menu-request/store', [MenuRequestController::class, 'store'])->name('vendor.menu-request.store');
        // Route::get('menu-request/edit/{id}', [MenuRequestController::class, 'edit'])->name('vendor.menu-request.edit');
        Route::post('menu-request/destroy/{id}', [MenuRequestController::class, 'destroy'])->name('vendor.menu-request.destroy');

        Route::get('invoice', [InvoiceController::class, 'index'])->name('vendor.invoice.index');
        Route::get('invoice/list', [InvoiceController::class, 'getVendorInvoiceData'])->name('vendor.invoice.list');
        Route::post('invoice/search-vendor-item', [InvoiceController::class, 'getVendorMenuItem'])->name('vendor.invoice.search-vendor-item');
        Route::get('invoice/create', [InvoiceController::class, 'create'])->name('vendor.invoice.create');
        Route::get('invoice/print-a4-size/{id}', [InvoiceController::class, 'print_a4_size'])->name('vendor.invoice.print-a4-size');
        Route::get('invoice/print-pos-invoice/{id}', [InvoiceController::class, 'posInvoice'])->name('vendor.invoice.print-pos-invoice');
        Route::post('invoice/store', [InvoiceController::class, 'store'])->name('vendor.invoice.store');
        Route::get('invoice/edit/{id}', [InvoiceController::class, 'edit'])->name('vendor.invoice.edit');
        Route::post('invoice/destroy/{id}', [InvoiceController::class, 'destroy'])->name('vendor.invoice.destroy');
    });
});

Route::get('/items/{code}', [ItemListController::class, 'index'])->name('items.index');
Route::get('/contact/{code}', [ItemListController::class, 'contact'])->name('items.contact');
Route::post('/vendor-contact', [ItemListController::class, 'save_contact'])->name('vendor.contact.save');


