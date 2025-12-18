<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
    ->name('password.update');


use App\Http\Controllers\Auth\VerificationController;

/* Email Verification */
Route::get('/email/verify', [VerificationController::class, 'show']) ->middleware('auth') ->name('verification.alert');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify']) ->middleware(['auth', 'signed']) ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend']) ->middleware(['auth', 'throttle:6,1']) ->name('verification.resend');

Route::withoutMiddleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/store', [App\Http\Controllers\StoreController::class, 'index'])->name('store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    });
});



use App\Http\Controllers\Payments\PaymentHistoryAdminController;

Route::prefix('admin/dashboard') ->middleware(['auth', 'adminonly'])->group(function () {

        Route::get('/payment-history', [PaymentHistoryAdminController::class, 'index'] )->name('admin.payment.history');

    });


Route::get('/admin/dashboard/profile', function () 
{ return view('manage.admin.profile.index');
})->middleware('auth')->name('admin.profile');

Route::get('/manage/profile/profile', function () {
    return view('manage.profile.index');
})->middleware('auth')->name('manage.profile.index');


Route::get('/command-queue', [App\Http\Controllers\API\CommandQueueAPIController::class, 'fetch']);


use App\Http\Controllers\Api\CommandQueueApiController;

Route::middleware('api.auth')->group(function () {
    Route::get('/v1/queue/pending/{server_id}', [CommandQueueApiController::class, 'pending']);
    Route::post('/v1/queue/complete', [CommandQueueApiController::class, 'complete']);
});

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/home');
});


Route::get('/statistics', [App\Http\Controllers\StatisticsController::class, 'index']);

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index']);

Route::get('/manage', fn() => redirect()->route('profile.index'));


Route::get('/store/checkout', [App\Http\Controllers\CheckoutController::class, 'index']);
Route::post('/store/checkout', [App\Http\Controllers\CheckoutController::class, 'verifiedbuy'])->name('verifiedbuy');
Route::get('/store/checkout/{id}', [App\Http\Controllers\CheckoutController::class, 'buy'])->name('buy');


Route::get('/checkout/success', function () {  return view('checkout.success'); })->name('checkout.success');
Route::get('/checkout/failed', function () { return view('checkout.failed'); })->name('checkout.failed');


Route::post('/razorpay/order', [App\Http\Controllers\Payments\RazorpayController::class, 'createOrder']) ->name('razorpay.order');

Route::post('/razorpay/verify', [App\Http\Controllers\Payments\RazorpayController::class, 'verifyPayment']) ->name('razorpay.verify');
Route::get('/manage/payments',  [App\Http\Controllers\Payments\PaymentHistoryController::class, 'index'] )->name('payment.history');


Route::get('/paypal', fn() => view('paypal'));

// ==================== PLAYER SECTION  ====================
Route::prefix('player')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\UserProfileController::class, 'index'])->name('profile.index');
    Route::resource('profile', App\Http\Controllers\Admin\UserProfileController::class);
    Route::resource('topicmanager', App\Http\Controllers\Admin\TopicsController::class);
    

Route::prefix('player')->group(function () {

    Route::get('changepassword', [App\Http\Controllers\Admin\UserProfileController::class, 'changepassword'])
        ->name('user.profile.changepassword');

    Route::get('editprofile', [App\Http\Controllers\Admin\UserProfileController::class, 'editprofile'])
        ->name('user.profile.editprofile');

    Route::post('updateprofile', [App\Http\Controllers\Admin\UserProfileController::class, 'updateprofile'])
        ->name('user.profile.updateprofile');

});


    Route::resource('claim', App\Http\Controllers\Claim\PackageClaimsController::class);
    Route::resource('paymenthistory', App\Http\Controllers\Admin\PaymentHistoryController::class);
    Route::resource('history', App\Http\Controllers\Admin\HistoryController::class);
});

Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');

use App\Http\Controllers\MCCMSController;

Route::prefix('mccms')->middleware('server.verify')->group(function () {

    Route::get('/add', [MCCMSController::class, 'add']);
    Route::get('/pending', [MCCMSController::class, 'pending']);
    Route::get('/done', [MCCMSController::class, 'done']);
    Route::post('/log', [MCCMSController::class, 'log']);

});


// ==================== ADMIN PANEL ====================
// Admin Dashboard Home
Route::get('admin/dashboard', 
    [App\Http\Controllers\Admin\DashboardController::class, 'index']
)->name('admin.dashboard');

// Admin Dashboard Home
Route::get('admin/dashboard', 
    [App\Http\Controllers\Admin\DashboardController::class, 'index']
)->name('admin.dashboard');

// ADMIN PANEL ROUTES
Route::prefix('admin/dashboard')->middleware(['auth', 'adminonly'])->group(function () {

    // Alerts
    Route::resource('alert', App\Http\Controllers\Admin\AlertController::class);
    Route::post('alert/doupdate', [App\Http\Controllers\Admin\AlertController::class, 'doUpdate'])
        ->name('alert.doUpdate');
    Route::post('alert/dodelete', [App\Http\Controllers\Admin\AlertController::class, 'doDelete'])
        ->name('alert.doDelete');

    // ————— FORUM: ADMIN TOPIC MANAGER —————
    Route::get('/topics', 
        [App\Http\Controllers\Admin\AdminTopicsController::class, 'index']
    )->name('admin.topic.index');

    Route::post('/topics/{id}/restore', 
        [App\Http\Controllers\Admin\AdminTopicsController::class, 'restore']
    )->name('admin.topic.restore');

    Route::post('/topics/{id}/forcedelete', 
        [App\Http\Controllers\Admin\AdminTopicsController::class, 'forcedelete']
    )->name('admin.topic.forcedelete');

    Route::delete('/topics/{id}', 
        [App\Http\Controllers\Admin\AdminTopicsController::class, 'destroy']
    )->name('admin.topic.delete');





    
    Route::get('changepassword', [App\Http\Controllers\Admin\AdminProfileController::class, 'changepassword'])->name('admin.profile.changepassword');
    Route::get('editprofile', [App\Http\Controllers\Admin\AdminProfileController::class, 'editprofile'])->name('admin.profile.editprofile');
    Route::post('updateprofile', [App\Http\Controllers\Admin\AdminProfileController::class, 'updateprofile'])->name('admin.profile.updateprofile');
    Route::resource('forumcontrol', App\Http\Controllers\Admin\ForumCategoriesController::class);
    Route::resource('packages/package', App\Http\Controllers\Admin\PackageController::class);
    Route::resource('packages/category', App\Http\Controllers\Admin\CategoryController::class);


	 Route::post('/currency-switch', function (\Illuminate\Http\Request $request) {
    session(['currency' => $request->currency]);
    return back();
})->name('currency.switch');

	 //  CATEGORIES 
   Route::resource('packages/category', App\Http\Controllers\Admin\CategoryController::class)
         ->names([
             'index'   => 'category.index',
             'store'   => 'category.store',
             'edit'    => 'category.edit',
             'update'  => 'category.update',
             'destroy' => 'category.destroy',
         ]);


    Route::post('packages/doupdate', [App\Http\Controllers\Admin\PackageController::class, 'doUpdate'])->name('packages.doUpdate');
    Route::post('packages/dodelete', [App\Http\Controllers\Admin\PackageController::class, 'doDelete'])->name('packages.doDelete');

    Route::resource('dashboard', App\Http\Controllers\Admin\DashboardController::class);
    Route::resource('paymentmethod', App\Http\Controllers\Admin\PaymentMethodController::class);
    Route::resource('server', App\Http\Controllers\Admin\ServerSettingsController::class);
    Route::post('server/doupdate', [App\Http\Controllers\Admin\ServerSettingsController::class, 'doUpdate'])->name('server.doUpdate');
    Route::post('server/dodelete', [App\Http\Controllers\Admin\ServerSettingsController::class, 'doDelete'])->name('server.doDelete');

    Route::resource('settings', App\Http\Controllers\Admin\GeneralSettingsController::class);

    Route::get('serverconsole', [App\Http\Controllers\Admin\ServerConsoleController::class, 'index'])->name('serverconsole');
    Route::post('serverconsole', [App\Http\Controllers\Admin\ServerConsoleController::class, 'store'])->name('serverconsole.query');

    Route::resource('usereditor', App\Http\Controllers\Admin\UserController::class);
    Route::post('usereditor/{id}/ban', [App\Http\Controllers\Admin\UserController::class, 'ban'])->name('usereditor.ban');
    Route::post('usereditor/doupdate', [App\Http\Controllers\Admin\UserController::class, 'doUpdate'])->name('usereditor.doUpdate');
    Route::post('usereditor/dodelete', [App\Http\Controllers\Admin\UserController::class, 'doDelete'])->name('usereditor.doDelete');

    Route::get('trash', [App\Http\Controllers\Admin\TrashController::class, 'index'])->name('trash.index');
    Route::post('trash/user/{id}/rollback', [App\Http\Controllers\Admin\TrashController::class, 'rollbackUser'])->name('trash.rollbackUser');
    Route::post('trash/user/{id}/forcedelete', [App\Http\Controllers\Admin\TrashController::class, 'forcedeleteUser'])->name('trash.forcedeleteUser');
    Route::post('trash/packages/{id}/rollback', [App\Http\Controllers\Admin\TrashController::class, 'rollbackPackage'])->name('trash.rollbackPackageshop');
    Route::post('trash/packages/{id}/forcedelete', [App\Http\Controllers\Admin\TrashController::class, 'forcedeletePackage'])->name('trash.forcedeletePackageshop');
});

// ==================== FORUM ====================
Route::get('/test', fn() => view('test'));
Route::get('/forum', [App\Http\Controllers\Forum\ForumController::class, 'index'])->name('forum.main');

Route::prefix('forum')->group(function () {
    Route::resource('topic', App\Http\Controllers\Forum\ForumTopicsController::class);
    Route::post('topic/restore/{id}/rollback', [App\Http\Controllers\Admin\TopicsController::class, 'restore'])->name('topicmanager.restore');
    Route::post('topic/forcedelete/{id}/forcedelete', [App\Http\Controllers\Admin\TopicsController::class, 'forcedelete'])->name('topicmanager.forcedelete');
    Route::resource('forumcategory', App\Http\Controllers\Forum\ForumCategoryController::class);
    Route::resource('comment', App\Http\Controllers\Forum\ForumCommentsController::class);
});