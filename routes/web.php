<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\ThematiquesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\FactsController;
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
Route::get('/messages/{chatId}', 'App\Http\Controllers\ChatsController@view')->name('frontend.SingleChatComponent');

Route::get('/admin/posts', [BlogController::class, 'posts'])->name('posts')->middleware('auth');
Route::get('/admin/posts/create', [BlogController::class, 'create'])->middleware('auth');
Route::post('/admin/posts/store', [BlogController::class, 'store'])->middleware('auth');
Route::get('/admin/posts/update/{id}', [BlogController::class, 'update'])->middleware('auth');
Route::post('/admin/posts/update/', [BlogController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/posts/destroy/{id}', [BlogController::class, 'destroy'])->middleware('auth');

Route::get('/admin/events', [EventsController::class, 'events'])->name('events')->middleware('auth');
Route::get('/admin/events/create', [EventsController::class, 'create'])->middleware('auth');
Route::post('/admin/events/store', [EventsController::class, 'store'])->middleware('auth');
Route::get('/admin/events/update/{id}', [EventsController::class, 'update'])->middleware('auth');
Route::post('/admin/events/update/', [EventsController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/events/destroy/{id}', [EventsController::class, 'destroy'])->middleware('auth');

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

Route::get('/admin/thematiques', [ThematiquesController::class, 'thematiques'])->name('thematiques')->middleware('auth');
// Route::get('/admin/thematiques/create', [ThematiquesController::class, 'create'])->middleware('auth');
Route::post('/admin/thematiques/store', [ThematiquesController::class, 'store'])->middleware('auth');
// Route::get('/admin/thematiques/update/{id}', [ThematiquesController::class, 'update'])->middleware('auth');
Route::post('/admin/thematiques/update/', [ThematiquesController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/thematiques/destroy/{id}', [ThematiquesController::class, 'destroy'])->middleware('auth');

Route::get('/admin/categories', [CategoriesController::class, 'categories'])->name('categories')->middleware('auth');
// Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->middleware('auth');
Route::post('/admin/categories/store', [CategoriesController::class, 'store'])->middleware('auth');
// Route::get('/admin/categories/update/{id}', [CategoriesController::class, 'update'])->middleware('auth');
Route::post('/admin/categories/update/', [CategoriesController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/categories/destroy/{id}', [CategoriesController::class, 'destroy'])->middleware('auth');
Route::post('/admin/new-user-to-user', [AutomaticEmailsController::class, 'new_user_to_user'])->name('new.user.to.user');
Route::post('/admin/new-user-to-admin', [AutomaticEmailsController::class, 'new_user_to_admin'])->name('new-user-to-admin');
Route::post('admin/positive-admission-to-user', [AutomaticEmailsController::class, 'positive_admission_to_user'])->name('positive-admission-to-user');
Route::post('admin/negative-admission-to-user', [AutomaticEmailsController::class, 'negative_admission_to_user'])->name('negative-admission-to-user');
Route::post('admin/welcome-to-user', [AutomaticEmailsController::class, 'welcome_to_user'])->name('welcome-to-user');
Route::post('admin/report-to-user', [AutomaticEmailsController::class, 'report_to_user'])->name('report-to-user');
Route::post('admin/report-to-admin', [AutomaticEmailsController::class, 'report_to_admin'])->name('report-to-admin');
Route::post('admin/positive-report-to-user', [AutomaticEmailsController::class, 'positive_report_to_user'])->name('positive-report-to-user');
Route::post('admin/negative-report-to-user', [AutomaticEmailsController::class, 'negative_report_to_user'])->name('negative-report-to-user');
Route::post('admin/new-tool-to-admin', [AutomaticEmailsController::class, 'new_tool_to_admin'])->name('new-tool-to-admin');
Route::post('admin/new-blog-to-admin', [AutomaticEmailsController::class, 'new_blog_to_admin'])->name('new-blog-to-admin');


require __DIR__.'/auth.php';
