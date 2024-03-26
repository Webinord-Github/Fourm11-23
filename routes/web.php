<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ToolsController;
use App\Http\Controllers\Admin\ToolsGuardController;
use App\Http\Controllers\Admin\BlogGuardController;
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
use App\Http\Controllers\Admin\ChatbotMessages;
use App\Http\Controllers\Admin\ChatbotsController;
use App\Http\Controllers\Admin\ElementorController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SignetsController;
use App\Http\Controllers\Admin\ConversationsController;
use App\Http\Controllers\userFollowingsController;
use App\Http\Controllers\SearchBarController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\ReportsController;


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
Route::post('admin/parametres/cookie', [AdminSettingsController::class, 'cookieScript'])->name('cookie-script')->middleware('admin');
Route::put('/admin/refusedReply{signalement}', [ReportsController::class, 'deletedReply'])->name('deleted-reply');
Route::resource('/admin/signalements', ReportsController::class)->middleware('admin');
Route::post('/forum/bookmark', [ConversationsController::class, 'conversationBookmark'])->name('conversation.bookmark');
Route::post('/admin/parametres/maintenance', [AdminSettingsController::class, 'maintenanceMode'])->name('maintenance.mode');
Route::resource('/admin/parametres', AdminSettingsController::class);
Route::post('/search', [SearchBarController::class, 'searchBar'])->name('search');
Route::post('/evenements/bookmark', [eventsController::class, 'eventBookmarks'])->name('event.bookmark');
Route::post('/les-membres/following', [userFollowingsController::class, 'userFollowing'])->name('user.follow');
Route::post('/admin/chatbot/activate', [ChatbotsController::class, 'enableChatbot'])->name('enable-chatbot')->middleware('admin');
Route::resource('/admin/chatbot', ChatbotsController::class);
Route::post('/admin/getNewMessages', [ChatbotsController::class, 'getNewMessages'])->name('getNewMessages');
Route::post('/admin/get-messages-for-user', [ChatbotsController::class, 'getMessagesForUser'])->name('getMessagesForUser');
Route::post('/admin/getNewMessageNotif', [ChatbotsController::class, 'getNewMessageNotif'])->name('getNewMessageNotif');
Route::post('/loadMessages', [ChatbotsController::class, 'loadMessagesFromAdmin'])->name('loadMessagesFromAdmin');
Route::post('/getMessages', [ChatbotsController::class, 'getInstantMessagesFromAdmin'])->name('getInstantMessagesFromAdmin');
Route::post('/SendMessagesToAdmin', [ChatbotsController::class, 'userStore'])->name('userStore');
Route::post('messagesNotif', [ChatbotsController::class, 'getNewMessageNotifFromAdmin'])->name('getNewMessageNotifFromAdmin');
Route::get('/lien-invalide', 'App\Http\Controllers\InvalidPasswordResetLinkController@index');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/', 'App\Http\Controllers\Admin\PagesController@homepage');
Route::get('/calendar/{month?}', 'App\Http\Controllers\Admin\CalendarController@index')->name('calendar');
Route::get('/blogue/{post}', [BlogController::class, 'show'])->name('post.show');

Route::get('/admin/calendar', 'App\Http\Controllers\Admin\CalendarController@index');
Route::resource('/admin/emails', 'App\Http\Controllers\Admin\AutomaticEmailsController');
Route::get('/admin/utilisateurs-bannis', 'App\Http\Controllers\Admin\BanUserController@index')->name('banusers.index');
Route::post('/admin/usersguard/banuser', 'App\Http\Controllers\Admin\UsersGuardController@banUser')->name('banUser');
Route::post('/unbanuser', 'App\Http\Controllers\Admin\BanUserController@unbanUser')->name('unbanUser');
Route::post('/update-menu-order', 'App\Http\Controllers\Admin\PagesController@updateMenuOrder')->name('update-menu-order');
// custom Auth Routes
Route::get('sinscrire', [RegisteredUserController::class, 'create'])
->name('custom.register.form')->middleware('guest');
Route::post('sinscrire', [RegisteredUserController::class, 'store']);
Route::get('mon-compte', [AuthenticatedSessionController::class, 'create'])
->name('mon-compte');
Route::post('mon-compte', [AuthenticatedSessionController::class, 'store']);
// routes/web.php
Route::get('/profil/{id}', 'App\Http\Controllers\Admin\UsersController@show')->name('profile.show');
Route::get('/messages', 'App\Http\Controllers\MessageController@index')->name('messages')->middleware('auth');
Route::post('/chat-store', [ChatsController::class, 'store'])->name('chatstore')->middleware('auth');
Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');

Route::post('/reply-like', 'App\Http\Controllers\Admin\LikesController@replyLike')->name('reply-like');
Route::post('/conversation-like', 'App\Http\Controllers\Admin\LikesController@conversationLike')->name('conversation-like');

Route::post('/signet-tool', [SignetsController::class, 'signets'])->name('signet-tool');
Route::post('/api/signet', [ApiController::class, 'signets']);
Route::get('/api/tools', [ApiController::class, 'tools']);
Route::get('/api/themes', [ApiController::class, 'thematiques']);
Route::post('/api/bookmark-post', [ApiController::class, 'postsBookmarks']);
Route::post('/api/bookmark-theme', [ApiController::class, 'thematiquesBookmarks']);
Route::post('/api/profile-infos', [ApiController::class, 'profileInfos']);

Route::resource('/admin/menu', 'App\Http\Controllers\Admin\MenuController');

Route::post('/fetchMessage/{receiverId}', 'App\Http\Controllers\MessageController@fetchMessages')->name('fetchMessage');


Route::post('/broadcast', [MessageController::class, 'broadcast'])->name('broadcast');
Route::post('/receive', 'App\Http\Controllers\MessageController@receive')->name('receiveMessage');

Route::get('/admin', [DashboardController::class, 'index'])->middleware('admin');


Route::get('/sendmail', 'App\Http\Controllers\Admin\EmailController@index')->name('emails.test');
Route::post('/sendmails', 'App\Http\Controllers\Admin\EmailController@sendEmail')->name('send.email');

Route::get('/mon-compte', [AlternativeAuthController::class, 'showLoginForm'])->name('alternative.login');
Route::post('/mon-compte', [AlternativeAuthController::class, 'login']);

Route::resource('/admin/users', UsersController::class);
Route::get('/mon-profil', [UsersController::class, 'show'])->name('user.show');

Route::post('/update-notifs-check', 'App\Http\Controllers\UsersNotifsUpdateController@updateNotifsCheck')->name('update-notifs-check');

Route::post('/singleNotifsReadUpdate', 'App\Http\Controllers\UsersNotifsUpdateController@singleNotifsReadUpdate')->name('singleNotifsReadUpdate');

Route::resource('/admin/conversations', 'App\Http\Controllers\Admin\ConversationsController');
Route::post('/forum/nouvelle-conversation', [ConversationsController::class, 'conversation_added_by_user'])->name('new.conversation.by.user');
Route::post('admin/forum/published', [ConversationsController::class, 'conversationsPublished'])->name('conversations.published');

Route::resource('/replies', 'App\Http\Controllers\Admin\RepliesController');

Route::post('/user-reply', 'App\Http\Controllers\Admin\RepliesController@userReply')->name('user-reply');

Route::post('/reply-report', 'App\Http\Controllers\Admin\RepliesController@replyReport')->name('reply-report');

Route::put('/admin/users/{user}/status', 'App\Http\Controllers\Admin\UsersController@updateUserPassword')->name('users.update-password');

Route::resource('/admin/medias', 'App\Http\Controllers\Admin\MediasController');

Route::resource('/admin/pages', 'App\Http\Controllers\Admin\PagesController');
Route::post('/replies/delete', 'App\Http\Controllers\Admin\RepliesController@destroy')->name('replies.destroy');
Route::resource('/admin/pagesguard', 'App\Http\Controllers\Admin\PagesGuardController');
Route::resource('/admin/usersguard', 'App\Http\Controllers\Admin\UsersGuardController')->middleware('auth');
Route::resource('/admin/toolsguard', ToolsGuardController::class)->middleware('auth');
Route::resource('/admin/blogguard', BlogGuardController::class)->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mon-profil/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/membre/{id}', [ProfileController::class, 'membre'])->name('profile.membre');
    Route::put('/mon-profil/update/{user}', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

Route::resource('/admin/posts', BlogController::class)->middleware('auth');
Route::post('/post-bookmark', [BlogController::class, 'blogBookmarks'])->name('blog-bookmarks')->middleware('auth');
Route::post('/blogue/send', [BlogController::class, 'send'])->name('post.send')->middleware('auth');
Route::resource('admin/events', EventsController::class)->middleware('auth');
Route::resource('admin/thematiques', ThematiquesController::class)->middleware('auth');
Route::resource('admin/facts', FactsController::class)->middleware('auth');
Route::post('/evenements/nouvel-evenement', [EventsController::class, 'userAddEvent'])->name('new.user.event')->middleware('auth');
Route::post('admin/events/published', [EventsController::class, 'eventsPublished'])->name('events.published');
Route::get('/blogue/{post}', [BlogController::class, 'show'])->name('post.show');

Route::resource('admin/test', TestController::class)->middleware('auth');

Route::post('/boite-a-outils/send', [ToolsController::class, 'send'])->name('tool.send')->middleware('auth');
Route::get('/admin/tools', [ToolsController::class, 'tools'])->name('tools')->middleware('auth');
Route::get('/admin/tools/create', [ToolsController::class, 'create'])->middleware('auth');
Route::post('/admin/tools/store', [ToolsController::class, 'store'])->middleware('auth');
Route::get('/admin/tools/update/{id}', [ToolsController::class, 'update'])->middleware('auth');
Route::post('/admin/tools/update/', [ToolsController::class, 'storeUpdate'])->middleware('auth');
Route::post('/admin/tools/destroy/', [ToolsController::class, 'destroy'])->name('tools.destroy')->middleware('auth');

Route::get('/admin/cards', [CardsController::class, 'cards'])->name('cards')->middleware('auth');
Route::get('/admin/cards/create', [CardsController::class, 'create'])->middleware('auth');
Route::post('/admin/cards/store', [CardsController::class, 'store'])->middleware('auth');
Route::get('/admin/cards/update/{id}', [CardsController::class, 'update'])->middleware('auth');
Route::post('/admin/cards/update/', [CardsController::class, 'storeUpdate'])->middleware('auth');
Route::get('/admin/cards/destroy/{id}', [CardsController::class, 'destroy'])->middleware('auth');

Route::get('/elementor/medias', [ElementorController::class, 'medias']);
Route::post('/elementor/upload', [ElementorController::class, 'upload'])->name('elementor.upload');


Route::get('/{url}', 'App\Http\Controllers\Admin\PagesController@view')->name('frontend.page');

require __DIR__.'/auth.php';
