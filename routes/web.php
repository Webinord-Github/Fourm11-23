<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\ThematiquesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\FactsController;
use App\Http\Controllers\Admin\CardsController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\AlternativeAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\AutomaticEmailsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Auth::routes();
Route::resource('/admin/emails', 'App\Http\Controllers\Admin\AutomaticEmailsController');
Route::get('/admin/utilisateurs-bannis', 'App\Http\Controllers\Admin\BanUserController@index')->name('banusers.index');
Route::post('/banuser', 'App\Http\Controllers\Admin\UsersGuardController@banUser')->name('banUser');
Route::post('/unbanuser', 'App\Http\Controllers\Admin\BanUserController@unbanUser')->name('unbanUser');
Route::post('/update-menu-order', 'App\Http\Controllers\Admin\PagesController@updateMenuOrder')->name('update-menu-order');
// custom Auth Routes
Route::get('sinscrire', [RegisteredUserController::class, 'create'])
->name('register');
Route::post('sinscrire', [RegisteredUserController::class, 'store']);
Route::get('mon-compte', [AuthenticatedSessionController::class, 'create'])
->name('mon-compte');
Route::post('mon-compte', [AuthenticatedSessionController::class, 'store']);
// routes/web.php

Route::get('/messages', 'App\Http\Controllers\MessageController@index')->name('messages')->middleware('auth');
Route::post('/chat-store', [ChatsController::class, 'store'])->name('chatstore')->middleware('auth');
Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');


Route::resource('/admin/menu', 'App\Http\Controllers\Admin\MenuController');

Route::post('/fetchMessage/{receiverId}', 'App\Http\Controllers\MessageController@fetchMessages')->name('fetchMessage');


Route::post('/broadcast', [MessageController::class, 'broadcast'])->name('broadcast');
Route::post('/receive', 'App\Http\Controllers\MessageController@receive')->name('receiveMessage');

Route::get('/admin', [DashboardController::class, 'index'])->middleware('admin');


Route::get('/sendmail', 'App\Http\Controllers\Admin\EmailController@index')->name('emails.test');
Route::post('/sendmails', 'App\Http\Controllers\Admin\EmailController@sendEmail')->name('send.email');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/mon-compte', [AlternativeAuthController::class, 'showLoginForm'])->name('alternative.login');
Route::post('/mon-compte', [AlternativeAuthController::class, 'login']);

Route::resource('/admin/users', 'App\Http\Controllers\Admin\UsersController');

Route::post('/update-notifs-check/{userId}/', 'App\Http\Controllers\UsersNotifsUpdateController@updateNotifsCheck')->name('update-notifs-check');

Route::post('/singleNotifsReadUpdate', 'App\Http\Controllers\UsersNotifsUpdateController@singleNotifsReadUpdate')->name('singleNotifsReadUpdate');

Route::resource('/admin/conversations', 'App\Http\Controllers\Admin\ConversationsController');

Route::resource('/replies', 'App\Http\Controllers\Admin\RepliesController');

Route::put('/admin/users/{user}/status', 'App\Http\Controllers\Admin\UsersController@updateUserPassword')->name('users.update-password');

Route::resource('/admin/medias', 'App\Http\Controllers\Admin\MediasController');

Route::resource('/admin/pages', 'App\Http\Controllers\Admin\PagesController');
Route::post('/replies/delete', 'App\Http\Controllers\Admin\RepliesController@destroy')->name('replies.destroy');
Route::resource('/admin/pagesguard', 'App\Http\Controllers\Admin\PagesGuardController');
Route::resource('/admin/usersguard', 'App\Http\Controllers\Admin\UsersGuardController');

Route::get('/forum', 'App\Http\Controllers\Admin\ConversationsController@view')->name('frontend.forum');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('{url}', 'App\Http\Controllers\Admin\PagesController@view')->name('frontend.page');

Route::resource('admin/posts', BlogController::class)->middleware('auth');
Route::resource('admin/events', EventsController::class)->middleware('auth');

Route::resource('admin/test', TestController::class)->middleware('auth');

// Route::get('/admin/test/create', [TestController::class, 'create'])->middleware('auth');
// Route::post('/admin/test/store', [TestController::class, 'store'])->middleware('auth');
// Route::get('/admin/test/update/{id}', [TestController::class, 'update'])->middleware('auth');
// Route::post('/admin/test/update/', [TestController::class, 'storeUpdate'])->middleware('auth');
// Route::get('/admin/test/destroy/{id}', [TestController::class, 'destroy'])->middleware('auth');

Route::get('/admin/tools', [ToolsController::class, 'tools'])->name('tools')->middleware('auth');
Route::get('/admin/tools/create', [ToolsController::class, 'create'])->middleware('auth');
Route::post('/admin/tools/store', [ToolsController::class, 'store'])->middleware('auth');
Route::get('/admin/tools/update/{id}', [ToolsController::class, 'update'])->middleware('auth');
Route::post('/admin/tools/update/', [ToolsController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/tools/destroy/{id}', [ToolsController::class, 'destroy'])->middleware('auth');

Route::get('/admin/facts', [FactsController::class, 'facts'])->name('facts')->middleware('auth');
Route::get('/admin/facts/create', [FactsController::class, 'create'])->middleware('auth');
Route::post('/admin/facts/store', [FactsController::class, 'store'])->middleware('auth');
Route::get('/admin/facts/update/{id}', [FactsController::class, 'update'])->middleware('auth');
Route::post('/admin/facts/update/', [FactsController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/facts/destroy/{id}', [FactsController::class, 'destroy'])->middleware('auth');

Route::get('/admin/cards', [CardsController::class, 'cards'])->name('cards')->middleware('auth');
Route::get('/admin/cards/create', [CardsController::class, 'create'])->middleware('auth');
Route::post('/admin/cards/store', [CardsController::class, 'store'])->middleware('auth');
Route::get('/admin/cards/update/{id}', [CardsController::class, 'update'])->middleware('auth');
Route::post('/admin/cards/update/', [CardsController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/cards/destroy/{id}', [CardsController::class, 'destroy'])->middleware('auth');

Route::get('/admin/thematiques', [ThematiquesController::class, 'thematiques'])->name('thematiques')->middleware('auth');
Route::post('/admin/thematiques/store', [ThematiquesController::class, 'store'])->middleware('auth');
Route::post('/admin/thematiques/update/', [ThematiquesController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/thematiques/destroy/{id}', [ThematiquesController::class, 'destroy'])->middleware('auth');



require __DIR__.'/auth.php';
