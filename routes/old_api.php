<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});


Route::post('login', 'API\LoginController@login');
Route::post('register', 'API\LoginController@register');
Route::post('forgot-password', 'API\LoginController@send_reset_password_link');
//Route::post('reset-password', 'API\LoginController@validate_password');

Route::post('login/facebook','API\LoginController@login_facebook');
Route::post('login/google','API\LoginController@login_google');

Route::group(['middleware' => 'auth:api'], function(){

	Route::post('change-password','API\LoginController@check_password');

    Route::get('logout','API\LoginController@logout');

	Route::get('dashboard','API\MeasurementsApiController@dashboard');
	Route::post('details', 'API\LoginController@details');
	Route::apiResource('/measurements','API\MeasurementsApiController');
	Route::post('checkMeasurementTitle','API\MeasurementsApiController@check_measurement_name');
	Route::post('imageUpload','API\MeasurementsApiController@image_upload');
	Route::get('help-text/{uom}','API\MeasurementsApiController@show_measurement_images');
	Route::get('edit-measurements/{id}','API\MeasurementsApiController@editMeasurements');
	//Route::apiResource('projects','API\ProjectsController');

	/* project library */

Route::get('project-library','API\ProjectsController@get_project_library');
Route::get('projects-library/generated','API\ProjectsController@get_generated_patterns');
Route::get('projects-library/workinprogress','API\ProjectsController@get_workinprogress_patterns');
Route::get('projects-library/completed','API\ProjectsController@get_completed_patterns');
Route::get('projects-archive','API\ProjectsController@get_project_library_archive');
Route::get('delete-project/{id}','API\ProjectsController@project_delete');
Route::get('move-to-project-library/{id}','API\ProjectsController@move_to_project_library');
Route::get('move-to-archive/{id}','API\ProjectsController@move_to_archive');
Route::get('move-to-generated/{id}','API\ProjectsController@move_to_generated');
Route::get('move-to-workinprogress/{id}','API\ProjectsController@move_to_workinprogress');
Route::get('move-to-completed/{id}','API\ProjectsController@move_to_completed');
Route::get('new-patterns-to-archive/{order_id}','API\ProjectsController@order_to_archive');
Route::get('new-patterns-to-library/{order_id}','API\ProjectsController@order_to_library');

Route::get('available-products/{type}','API\ProjectsController@available_products');
Route::get('productData/{id}','API\ProjectsController@get_products_data');
Route::get('externalProjectData','API\ProjectsController@get_external_data');

Route::post('create-custom-project','API\ProjectsController@create_custom_project');
Route::post('create-non-custom-project','API\ProjectsController@create_custom_project');
Route::post('create-external-project','API\ProjectsController@create_external_project');
Route::get('generate-external-pattern/{id}','API\ProjectsController@generate_external_pattern');
Route::get('generate-custom-pattern/{id}','API\ProjectsController@generate_custom_pattern');
Route::get('generate-non-custom-pattern/{id}','API\ProjectsController@generate_non_custom_pattern');
Route::get('project-image-library/{id}','API\ProjectsController@project_image_library');
Route::post('project-image-upload','API\ProjectsController@project_image_upload');

Route::get('project-notes/{project_id}','API\ProjectsController@get_project_notes');
Route::post('project-notes','API\ProjectsController@add_project_notes');
Route::get('delete-project-notes/{id}','API\ProjectsController@delete_project_notes');
Route::get('complete-project-notes/{id}','API\ProjectsController@mark_project_complete');
Route::post('delete-all-project-notes','API\ProjectsController@delete_all_project_notes');
/* project library */

/* subscriptions */
Route::get('subscription-plans','API\SubscriptionController@index');
/* subscriptions */

/* Products */
Route::post('addWishlist','API\ProductsController@add_wishlist');
Route::post('RemoveWishlist','API\ProductsController@remove_wishlist');
Route::get('RemoveAllWishlist','API\ProductsController@remove_all_wishlist');
Route::get('wishlist','API\ProductsController@wishlist');
Route::get('getCart','API\CartController@get_cart');
Route::post('addToCart','API\CartController@add_cart');
Route::get('removeItem/{id}','API\CartController@remove_item');
Route::get('removeAllItems','API\CartController@remove_all_items');
Route::post('buyNow','API\CartController@BuyNow');
Route::post('add-comment','API\ProductsController@add_comment');
Route::post('delete-product-comment','API\ProductsController@delete_comment');
Route::get('getProduct/{id}','API\ProductsController@get_product');

Route::post('vote-comment','API\ProductsController@vote_comment');
Route::post('unvote-comment','API\ProductsController@unvote_for_comment');
/* Products */


/* Address */
Route::post('add-address','API\UserController@add_address');
Route::get('getAddress','API\CartController@user_address');
Route::get('edit-address/{id}','API\UserController@edit_address');
Route::post('update-address','API\UserController@update_address');
Route::get('delete-address/{id}','API\UserController@delete_address');
Route::post('setDefaultaddress','API\UserController@setDefaultaddress');

Route::get('newletter-check','API\UserController@newletter_check');
Route::post('subscribe-newsletters','API\UserController@subscribe_newsletters');
Route::get('newsletter/unsubscribe/{token}','API\UserController@newsletter_unscbscribe');
/* address */

/* my orders */
Route::get('my-orders','API\UserController@my_orders');
Route::get('subscriptionOrderDetails','API\SubscriptionController@getMyOrder');
Route::get('OrderDetails','API\UserController@getMyOrderDetails');
/* my orders */

/* timeline */
Route::get('connect','API\ConnectController@get_all_posts');
Route::get('connect/{id}','API\ConnectController@getTimelinebyId');
Route::post('deletePost','API\ConnectController@timeline_deletePost');
Route::get('edit-post/{id}','API\ConnectController@timeline_editPost');
Route::post('add-post','API\ConnectController@timeline_addPost');
Route::post('update-post','API\ConnectController@timeline_updatePost');
Route::post('deleteTimelineImage','API\ConnectController@delete_timeline_image');
Route::post('likeUnlikePost','API\ConnectController@likeUnlikePost');
Route::post('add-post-comment','API\ConnectController@timeline_addComment');
Route::get('edit-comment/{id}','API\ConnectController@timeline_editComment');
Route::post('update-comment','API\ConnectController@timeline_updateComment');
Route::post('delete-comment','API\ConnectController@timeline_deleteComment');
Route::post('likeUnlikeComment','API\ConnectController@likeUnlikeComment');
Route::get('my-connections','API\ConnectController@my_connections');
Route::post('filter-my-connections','API\ConnectController@filter_my_connections');
Route::post('search-connections','API\ConnectController@search_my_connections');
Route::post('find-connections','API\ConnectController@find_connections');

Route::post('sendFriendRequest','API\ConnectController@sendFriendRequest');
Route::post('cancelFriendRequest','API\ConnectController@cancelFriendRequest');
Route::post('rejectFriendRequest','API\ConnectController@rejectFriendRequest');
Route::post('unfriendUser','API\ConnectController@removeFriend');
Route::post('acceptRequest','API\ConnectController@acceptRequest');
Route::post('follow','API\ConnectController@follow_user');
Route::post('unFollow','API\ConnectController@unfollow_user');
Route::get('gallery','API\ConnectController@user_gallery');
Route::get('suggested-connections','API\ConnectController@suggested_connections');
Route::get('my-profile','API\ConnectController@my_profile');
Route::get('other-profile/{id}','API\ConnectController@other_user_profile');
Route::post('update-aboutme','API\ConnectController@update_aboutme');
Route::get('edit-aboutme','API\ConnectController@edit_aboutme');
Route::get('editskillSet','API\ConnectController@edit_skillSet');
Route::post('updateskillSet','API\ConnectController@update_skillSet');
Route::get('editInterest','API\ConnectController@editInterest');
Route::post('updateInterest','API\ConnectController@update_interest');
Route::get('editContactDetails','API\ConnectController@editcontact_details');
Route::post('updateContactDetails','API\ConnectController@update_contact_details');
Route::post('updateProfilePiture','API\ConnectController@update_profile_picture');
Route::get('my-friend-requests','API\ConnectController@my_friend_requests');
/* timeline */

Route::apiResource('product','API\ProductsController');
Route::get('product-filters','API\ProductsController@get_all_filters');
Route::get('products','API\ProductsController@get_products_data_all');

/* Todo */
Route::apiResource('todo','API\TodoController');
Route::get('todoDeleteAll','API\TodoController@destroy_all');

Route::get('notifications','API\NotificationController@unread_notifications');
Route::get('allNotifications','API\NotificationController@all_notifications');
Route::get('markAsRead','API\NotificationController@markAsRead');
Route::get('deleteNotification/{id}','API\NotificationController@deleteNotification');

/* paypal subscription */
Route::get('getPlans','API\PaypalSubscriptionController@getPlans');
Route::get('paypalCreateSubscription/{plan_id}','API\PaypalSubscriptionController@createSubscription');

});

Route::get('subscriptionPaymentSuccess','API\PaypalSubscriptionController@paypalPaymentSuccess');
Route::get('subscriptionPaymentFail','API\PaypalSubscriptionController@paypalPaymentFail');


Route::get('success/{id}','API\CheckoutController@payment_success');
Route::get('failure/{id}','API\CheckoutController@payment_failure');
Route::get('place-order','API\CheckoutController@place_order');

Route::post('contact-us','API\HomepageController@contact_us');
Route::post('signUpKnitfit','API\HomepageController@SignupNewsletter');
