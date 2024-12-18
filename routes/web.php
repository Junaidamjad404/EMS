<?php

use Pusher\Pusher;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Attendee\TicketController;
use App\Http\Controllers\Attendee\AboutUsController;
use App\Http\Controllers\Attendee\ServiceController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Attendee\ResetPasswordController;
use App\Http\Controllers\Attendee\ForgotPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, config('app.supported_locales'))) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');
Route::get('/',  [AttendeeController::class, 'index'])->name('user.index');

Route::get('/login', function () {    return view('Attendees.login');  })->name('user.login');
Route::get('/register', function () {  return view('Attendees.register');})->name('user.register');
Route::get('/contact', function () {    return view('Attendees.contact');  })->name('user.contact');

Route::post('/login', [AttendeeController::class, 'login'])->name('user.store.login');
Route::post('/register', [AttendeeController::class, 'store'])->name('user.store');
Route::get('/about',  [AboutUsController::class, 'index'])->name('user.about');
Route::get('/service',  [ServiceController::class, 'index'])->name('user.service');
Route::get('/event',[AttendeeController::class,'events'])->name('user.events');
Route::get('/event/{id}/detail',  [AttendeeController::class, 'event_detail'])->name('user.event.details');
Route::post('/events/filter', [EventController::class, 'filter'])->name('events.filter');


// Route::post('/notifications/send', [NotificationController::class, 'send']);

Route::middleware('auth')->group(function(){
    Route::get('/home',  [AttendeeController::class, 'index'])->name('user.index.home');
    Route::get('/attendee/logout', [AttendeeController::class, 'logout'])->name('attendee.logout');
    Route::get('user/profile', [AttendeeController::class, 'show'])->name('user.profile.show');
    Route::put('user/profile/update', [AttendeeController::class, 'update'])->name('user.profile.update');
    Route::get('/user/orders', [AttendeeController::class, 'orders'])->name('user.orders');
    Route::get('events/{id}/tickets', [TicketController::class,'show'])->name('event.tickets');
    Route::post('/events/{id}/tickets/buy', [TicketController::class,'buy'])->name('tickets.buy');
    Route::post('/finalize-purchase', [TicketController::class, 'finalizePurchase'])->name('finalize.purchase');
    //PayPal Approved Url
    Route::get('/paypal/callback', [TicketController::class, 'handlePayPalCallback'])->name('paypal.callback');

});

Route::get('password/reset', [ForgotPasswordController::class, 'create'])->name('user.password.request');
Route::post('password/email', [ForgotPasswordController::class, 'store'])->name('user.password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'create'])->name('user.password.reset');
Route::prefix('attendee')->group(function () {
    Route::get('events/create', [AttendeeController::class, 'create_event'])->name('user.events.create');
    Route::post('events', [AttendeeController::class, 'store_event'])->name('user.events.store');
});
 
Route::get('auth/{provider}', [SocialController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);


Route::get('admin/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/organizer/not_approved', [EventController::class, 'notApproved'])->name('organizer.not_approved');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 
Route::middleware(['auth','active.organizer'])->group(function () {
    Route::resource('events', EventController::class)->except(['edit', 'destroy']);
    Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit')->middleware('can:update,event');
    Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('can:delete,event');
    Route::get('api/ticket-purchases/{eventId}', [TicketController::class, 'getTicketPurchases']);
    Route::post('api/ticket-purchases/{id}/attendance', [TicketController::class, 'updateAttendance']);

    Route::delete('/events/{eventId}/images/{imageId}', [EventController::class, 'deleteImage'])->name('events.images.delete');
    Route::delete('/events/{eventId}/videos/{videoId}', [EventController::class, 'deleteVideo'])->name('events.videos.delete');
    Route::prefix('events/{event}')->group(function () {
        Route::resource('ticket_types', TicketTypeController::class);
        Route::post('/ticket_types/sync', [TicketTypeController::class, 'syncTicketTypes'])->name('ticket_types.sync'); // Add sync route
        Route::get('/api/ticket-types', [TicketTypeController::class, 'getTicketTypesForEvent']);

    });
});
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Event Organizers Management
  Route::prefix('event-organizers')->group(function () {
        Route::get('{id}/status', [AdminController::class, 'updateStatus'])->name('eventOrganizers.status');
        Route::get('{id}/edit', [AdminController::class, 'edit'])->name('eventOrganizers.edit');
        Route::put('{id}', [AdminController::class, 'update'])->name('eventOrganizers.update');
        Route::delete('{id}', [AdminController::class, 'destroy'])->name('eventOrganizers.destroy');
        Route::get('{id}/events', [AdminController::class, 'showEvents'])->name('eventOrganizers.events');
    });

    // Event Status Management
    Route::patch('events/{event}/status', [AdminController::class, 'updateEventStatus'])->name('events.updateEventStatus');
    Route::get('events/filter/{eventOrganizerId}', [AdminController::class, 'listEventsByStatus'])->name('events.listEventsByStatus');

    // Roles and Permissions Management
    Route::prefix('roles-permissions')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index'])->name('roles.permissions.index');
        Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
        Route::post('/permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
        Route::patch('/roles/{role}/permissions', [RolePermissionController::class, 'assignPermissions'])->name('roles.permissions.assign');
        Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
        Route::delete('/permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
        Route::get('/roles/{id}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
    });
});
require __DIR__.'/auth.php';
