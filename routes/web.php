<?php
use Illuminate\Support\Facades\Route;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('new-subscriber', function () {
    return view('new-customers');
});

Route::get('existing-subscriber', function () {
    return view('existing-customers');
});

Route::get('/error', function () {
	if(Auth::check()){
		return view('errors.no-measurement');
	}else{
		return redirect('login');
	}
});


Route::get('test', function () {
    return view('test');
});

Route::get('privacy', function () {
    return view('privacy');
});

Route::get('home', function () {
	if(Auth::check()){
		return view('home');
	}else{
		return redirect('login');
	}
});

Route::get('showAllNotifications',function(){
    return view('notification.Topnotifications');
});

Route::get('/','Logincontroller@login_page');

Route::match(array('GET','POST'),'login',[
	'uses' => 'Logincontroller@login_page',
    'as' => 'login',
    'before' => 'guest'
]);

Route::match(array('GET','POST'),'register',[
	'uses' => 'Logincontroller@Register_validate',
    'as' => 'register'
]);

Route::get('user/agree-terms-conditions',function(){
    if(!Auth::check()){
        return redirect('/login');
    }
    return view('auth.invitation');
});

Route::get('skip-invitaton','Logincontroller@skip_invitation');

Route::post('update-user-roles','Logincontroller@update_user_roles');

Route::get('register/thankyou',function(){
    return view('auth.thankyou');
});

Route::post('subscribe-newsletters','AccountController@subscribe_newsletters');
Route::get('newsletter/unsubscribe/{token}','AccountController@newsletter_unscbscribe');

//Route::post('contact-us','AccountController@contact_us');

Route::get('logout',[
	'uses' => 'LoginController@logout',
    'as' => 'logout'
]);

Route::get('check-username','LoginController@checkUsername');
Route::get('check-email','LoginController@checkEmail');

Route::get('check-validpage/{token}','LoginController@check_validpage');
Route::get('resend-email/{id}','LoginController@resend_email');
Route::get('registration/check-user-email/{email}/{encemail}','LoginController@email_activate');
Route::get('reset-password','LoginController@reset_password');
Route::post('password-reset','LoginController@send_reset_password_link');
Route::get('validate/password/{token}','LoginController@validate_password');
Route::post('validate/newpassword','LoginController@validate_newpassword');

Route::match(array('GET','POST'),'change-password','AccountController@change_password');

Route::get('subscription','SubscriptionController@subscription_view');
Route::post('add-cart','SubscriptionController@add_to_cart');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

Route::get('auth/facebook', 'Auth\FacebookController@login_with_fb');
Route::get('auth/facebook/callback', 'Auth\FacebookController@fb_login_success');

/*
Route::get('paypal/ec-checkout', 'SubscriptionController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'SubscriptionController@getExpressCheckoutSuccess');
Route::get('paypal/adaptive-pay', 'SubscriptionController@getAdaptivePay');

Route::get('paypal/cancel-subscription', 'SubscriptionController@cancel_subscription');
Route::post('paypal/notify', 'SubscriptionController@notify');

Route::get('payment/success','SubscriptionController@getExpressCheckoutSuccess');
*/

Route::get('dashboard','DashboardController@index');

Route::get('addToProjectLibrary/{pid}','CheckoutController@add_to_project_library');

Route::get('shop-patterns','ShoppingController@index');
Route::get('product/{pid}/{slug}','ShoppingController@product_full_view');
Route::get('pattern-popup/{pid}',[
	'uses' => 'ShoppingController@pattern_popup',
    'as' => 'pattern-popup/{pid}'
]);
Route::get('search-products','ShoppingController@search_products');
Route::post('addComments','ShoppingController@add_comments');
Route::get('get-comments/{id}','ShoppingController@getproduct_comments');
Route::post('wishlist','ShoppingController@wishlist');
Route::get('wishlist','ShoppingController@my_wishlist');
Route::get('remove-wishlist/{id}','ShoppingController@remove_wishlist');
Route::post('delete-comment','ShoppingController@delete_comment');
Route::post('voteCheck','ShoppingController@vote_for_comment');
Route::post('unvoteCheck','ShoppingController@unvote_for_comment');
/* cart items */
Route::get('load-cart','CartController@get_cart');
Route::post('add-to-cart','CartController@add_to_cart');
Route::get('cart','CartController@my_cart');
Route::get('remove-all-items','CartController@remove_all_items');
Route::get('remove-item/{id}','CartController@getReduseByOne');
Route::get('checkout','CartController@checkout');
Route::get('getUserAddress','CartController@getUserAddress');

Route::get('buynow/{pid}','CartController@buy_now');

Route::post('placeOrder','CheckoutController@place_order');
Route::get('payment/cancel/{orderId}', 'CheckoutController@cancel')->name('payment.cancel');
Route::get('payment/success/{order_id}', 'CheckoutController@success')->name('payment.success');
Route::get('order/invoice/{orderId}','CheckoutController@payment_invoice');
Route::get('order/faild/{orderId}','CheckoutController@payment_faild');
Route::get('cancel/{orderId}', 'CheckoutController@cancel_order');
Route::get('print/{orderId}', 'CheckoutController@print_order');
Route::get('retry/order/{orderId}', 'CheckoutController@retry_order');

Route::get('my-account','AccountController@my_account');
Route::get('my-address','AccountController@my_address');
Route::get('my-orders','AccountController@myorders');
Route::get('add-address','AccountController@add_address');
Route::post('add-address','AccountController@add_my_address');
Route::get('edit-address/{id}','AccountController@edit_address');
Route::post('update-address','AccountController@update_my_address');
Route::get('delete-address/{id}','AccountController@delete_address');
Route::get('set-default/{id}','AccountController@set_default_address');



Route::get('paypal/ec-checkout', 'SubscriptionController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'SubscriptionController@getExpressCheckoutSuccess');
Route::get('paypal/adaptive-pay', 'SubscriptionController@getAdaptivePay');

Route::get('getTransactionDetails/{token}','CheckoutController@getTransactionDetailswithToken');

Route::get('subscription/cancel-payment','SubscriptionController@cancel_payment');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
	
	
});

Route::get('checkSession','LoginController@checkSession');

Route::get('get-only-users-info','ValidationController@send_unique_users_email');
Route::get('sendEmail','ValidationController@send_email');
Route::get('download-excel','ValidationController@download_excel');
Route::get('users/{start_date}/{end_date}/{type}','ValidationController@download_excel_request');

Route::get('getProductPurchaseData','ValidationController@get_products_purchase');
Route::get('getSubscriptionPurchaseData','ValidationController@get_all_subscription_users_data');

Route::get('/cookie/set','CookieController@setCookie');
Route::get('/cookie/get','CookieController@getCookie');
Route::get('/cookie/delete','CookieController@deleteCookie');

Route::get('knitterSubscriptions','API\PaypalSubscriptionController@index');
Route::get('allPlans','PaypalSubscriptionController@getAllPlans');
Route::get('check-login','PaypalSubscriptionController@checkLogin');
//Route::get('makePayment/{id}','PaypalSubscriptionController@create_subscription');
Route::post('makePayment','PaypalSubscriptionController@create_subscription');
Route::get('success','PaypalSubscriptionController@success');
Route::get('fail','PaypalSubscriptionController@fail');
Route::get('subscription/success/thankyou','PaypalSubscriptionController@success_thankyou');
Route::get('subscription/failed','PaypalSubscriptionController@payment_faild');
Route::get('checkSubscription/{id}','PaypalSubscriptionController@getSubscriptionDetails');
Route::get('getPlanDetails/{id}','PaypalSubscriptionController@getPlanDetails');
Route::post('cancelSubscription','PaypalSubscriptionController@cancelSubscription');
Route::get('get-user-address','PaypalSubscriptionController@get_user_address');

Route::get('feedback','FeedbackController@index');
Route::post('feedback/uploadImage','FeedbackController@uploadImage');
Route::post('feedback/removeImage','FeedbackController@removeImage');
Route::post('feedback/saveFeedback','FeedbackController@uploadFeedback');
Route::post('feedback/replyFeedback','FeedbackController@feedback_reply');
Route::get('feedback/show/{id}/{slug}','FeedbackController@show_feedback');
Route::get('subscription-webhooks','PaypalSubscriptionController@subscription_webhooks');

Route::get('login-with-user-id/{user_id}','ValidationController@get_login_with_user_id');

Route::get('send-projects-report','Reports\DailyReportController@sendProjectsReport');
Route::get('send-measurements-report','Reports\DailyReportController@sendMeasurementsReport');
Route::get('send-users-report','Reports\DailyReportController@sendUsersReport');
Route::get('send-users-weekly-report','Reports\DailyReportController@sendUsersWeeklyReport');
Route::get('send-users-projects-report','Reports\DailyReportController@sendUsersReportWithProjectsCount');

/* support */
Route::get('/support', 'SupportController@index');
Route::get('/support/create-ticket', 'SupportController@create_new_ticket');
Route::post('/support/uploadImage', 'SupportController@upload_image');
Route::post('support/removeImage','SupportController@remove_image');
Route::post('support/saveTicket','SupportController@saveTicket')->name('saveTicket');
Route::get('/support/{ticket_id}/show', 'SupportController@show_ticket');
Route::get('/support/reply/{ticket_id}', 'SupportController@support_reply');
Route::post('/support/saveReply','SupportController@saveReply')->name('saveReply');
Route::post('/support/reinitiate-ticket','SupportController@reInitiate_ticket')->name('reInitiateTcket');
Route::post('/support/close-ticket','SupportController@close_ticket')->name('closeTicket');
