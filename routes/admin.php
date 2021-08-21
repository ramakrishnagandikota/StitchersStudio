<?php

Route::group(['middleware' => ['web','roles'],'prefix' => 'admin'], function () {

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

	Route::get('/', [
        'uses' => 'Admin\Admincontroller@get_admin_home',
        'as' => '/',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('upload-images','Admin\Admincontroller@upload_image');
    Route::post('update-measurements-index','Admin\Admincontroller@update_measurements_index');

    Route::get('/dashboard', [
        'uses' => 'Admin\Admincontroller@get_admin_home',
        'as' => '/dashboard',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('browse-patterns', [
        'uses' => 'Admin\Productscontroller@my_products',
        'as' => 'browse-patterns',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('browse-patterns/{type}', [
        'uses' => 'Admin\Productscontroller@my_products',
        'as' => 'browse-patterns/{type}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('add-new-pattern', [
        'uses' => 'Admin\Productscontroller@add_new_pattern',
        'as' => 'add-new-pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('upload-image', [
        'uses' => 'Admin\Productscontroller@upload_image',
        'as' => 'upload-image',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('product-images', [
        'uses' => 'Admin\Productscontroller@product_images',
        'as' => 'product-images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('upload-product', [
        'uses' => 'Admin\Productscontroller@upload_product',
        'as' => 'upload-product',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('products-edit/{pid}', [
        'uses' => 'Admin\Productscontroller@edit_product',
        'as' => 'products-edit/{pid}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('delete-product-image/{id}', [
        'uses' => 'Admin\Productscontroller@delete_product_image',
        'as' => 'delete-product-image/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('update-product', [
        'uses' => 'Admin\Productscontroller@update_product',
        'as' => 'update-product',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('remove-pattern/{id}', [
        'uses' => 'Admin\Productscontroller@remove_pattern',
        'as' => 'remove-pattern/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('delete-product/{id}', [
        'uses' => 'Admin\Productscontroller@delete_product',
        'as' => 'delete-product/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('product-measurements/{id}', [
        'uses' => 'Admin\Productscontroller@product_measurements',
        'as' => 'product-measurements/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('measurement-add/{pid}', [
        'uses' => 'Admin\Productscontroller@measurement_add',
        'as' => 'measurement-add/{pid}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('insert-measurements', [
        'uses' => 'Admin\Productscontroller@insert_measurements',
        'as' => 'insert-measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('create-measurimage', [
        'uses' => 'Admin\Productscontroller@upload_measurement_image',
        'as' => 'create-measurimage',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('edit-measurement/{id}', [
        'uses' => 'Admin\Productscontroller@edit_measurement',
        'as' => 'edit-measurement/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('update-measurements', [
        'uses' => 'Admin\Productscontroller@update_measurements',
        'as' => 'update-measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('delete-measurement/{id}', [
        'uses' => 'Admin\Productscontroller@delete_measurement',
        'as' => 'delete-measurement/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('create-pattern/{id}/{uom}',[
        'uses' => 'Admin\Productscontroller@create_pattern',
        'as' => 'create-pattern/{id}/{uom}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('create-pattern/{id}/{uom}/{tid}',[
        'uses' => 'Admin\Productscontroller@create_pattern',
        'as' => 'create-pattern/{id}/{uom}/{tid}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('create-pattern-pdf',[
        'uses' => 'Admin\Productscontroller@create_pattern_pdf',
        'as' => 'create-pattern-pdf',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('remove-product-image',[
        'uses' => 'Admin\Productscontroller@remove_product_image',
        'as' => 'remove-product-image',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('add-pattern-instructions',[
        'uses' => 'Admin\Productscontroller@add_pattern_instructions',
        'as' => 'add-pattern-instructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('show-all-images',[
        'uses' => 'Admin\Productscontroller@get_images_for_pattern',
        'as' => 'show-all-images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('upload-images-for-pattern',[
        'uses' => 'Admin\Productscontroller@upload_images_for_pattern',
        'as' => 'upload-images-for-pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::post('upload-excel-sheet',[
        'uses' => 'Admin\Productscontroller@upload_excel_sheet',
        'as' => 'upload-excel-sheet',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	
	 /*** starts users ***/
    
    Route::get('cususers-view', [
        'uses' => 'Admin\Customerusercontroller@cususers_view',
        'as' => 'cususers-view',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('cususers-view/{status}', [
        'uses' => 'Admin\Customerusercontroller@cususers_view',
        'as' => 'cususers-view/{status}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::get('cususers-add', [
        'uses' => 'Admin\Customerusercontroller@cususers_add',
        'as' => 'cususers-add',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::post('cususers-insert', [
        'uses' => 'Admin\Customerusercontroller@cususers_insert',
        'as' => 'cususers-insert',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::get('cususers-edit/{id}', [
        'uses' => 'Admin\Customerusercontroller@cususers_edit',
        'as' => 'cususers-edit/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::get('cususer-delete/{id}', [
        'uses' => 'Admin\Customerusercontroller@cususer_delete',
        'as' => 'cususer-delete/{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::post('cususers-update', [
        'uses' => 'Admin\Customerusercontroller@cususers_update',
        'as' => 'cususers-update',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('check-paypal-email', [
        'uses' => 'Admin\Customerusercontroller@check_paypal_email',
        'as' => 'admin.check.paypal.email',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::get('manage/users-role', [
        'uses' => 'Admin\Customerusercontroller@manage_users_role',
        'as' => 'manage/users-role',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::post('/assign-roles', [
        'uses' => 'Admin\Customerusercontroller@postAdminAssignRoles',
        'as' => 'admin.assign',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    /*** end users ***/

    Route::get('users/{id}/measurements', [
        'uses' => 'Admin\Customerusercontroller@users_measurements',
        'as' => 'users/{id}/measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('users/{id}/projects', [
        'uses' => 'Admin\Customerusercontroller@users_projects',
        'as' => 'users/{id}/projects',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/subscriptions', [
        'uses' => 'Admin\SubscriptionPaymentController@subscription_data',
        'as' => 'admin.subscriptions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::post('/checkSubscription', [
        'uses' => 'Admin\SubscriptionPaymentController@checkSubscriptionDetails',
        'as' => 'admin.check.subscriptions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	
	/* Traditional pattern routes */

    Route::post('/upload-admin-pattern-images', [
        'uses' => 'Admin\ProductsController@upload_admin_pattern_images',
        'as' => 'admin.upload.pattern.images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/upload-admin-recomondation-images', [
        'uses' => 'Admin\ProductsController@upload_admin_recomondation_images',
        'as' => 'admin.upload.recomondation.images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/upload-admin-pattern-instructions', [
        'uses' => 'Admin\ProductsController@upload_admin_pattern_instructions',
        'as' => 'admin.upload.pattern.instructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('add-traditional-pattern', [
        'uses' => 'Admin\Productscontroller@add_traditional_pattern',
        'as' => 'add.traditional.pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('save-traditional-pattern', [
        'uses' => 'Admin\Productscontroller@save_traditional_pattern',
        'as' => 'admin.save.traditional.pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('edit-traditional-pattern/{id}', [
        'uses' => 'Admin\Productscontroller@edit_traditional_pattern',
        'as' => 'edit.traditional.pattern.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('update-traditional-pattern', [
        'uses' => 'Admin\Productscontroller@update_traditional_pattern',
        'as' => 'admin.update.traditional.pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/deleteYarnRecommmendations/{id}', [
        'uses' => 'Admin\ProductsController@deleteYarnRecommmendations',
        'as' => 'admin.deleteYarnRecommmendations',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/delete-yarn-image/{id}', [
        'uses' => 'Admin\ProductsController@deleteYarnRecommmendationsImages',
        'as' => 'admin.delete.yarn.image.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/delete-pattern-image/{id}', [
        'uses' => 'Admin\ProductsController@deletePatternImages',
        'as' => 'admin.delete.pattern.image.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/delete-pattern-reference-image/{id}', [
        'uses' => 'Admin\ProductsController@deleteReferenceImages',
        'as' => 'admin.delete.pattern.reference.image.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/deleteNeedles/{id}', [
        'uses' => 'Admin\ProductsController@deleteNeedles',
        'as' => 'admin.deleteNeedles',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/make-image-default', [
        'uses' => 'Admin\ProductsController@make_image_default',
        'as' => 'admin.make.image.default',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::post('/send-review-or-change-status', [
        'uses' => 'Admin\ProductsController@send_review_or_change_status',
        'as' => 'admin.sendReviewOrChangeStatus',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    /* Traditional pattern routes */
	
	/* check paypal details */
    Route::post('/check-paypal-credentials', [
        'uses' => 'Admin\ProductsController@check_paypal_credentials',
        'as' => 'admin.checkPaypalDetails',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    Route::post('/get-paypal-credentials', [
        'uses' => 'Admin\ProductsController@get_paypal_credentials',
        'as' => 'admin.getPaypalCredentials',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    /* check paypal details */
	
	/* broadcast */

    Route::get('broadcast', [
        'uses' => 'Admin\BroadcastController@broadcast',
        'as' => 'admin.broadcast',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('broadcast/notify', [
        'uses' => 'Admin\BroadcastController@broadcast_notify',
        'as' => 'admin.broadcast.notify',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('broadcast/user', [
        'uses' => 'Admin\BroadcastController@broadCastToDevice',
        'as' => 'admin.broadcast.user',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('broadcast/check', [
        'uses' => 'Admin\BroadcastController@getAllDeviceIds',
        'as' => 'admin.broadcast.check',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('broadcast/only-user', [
        'uses' => 'Admin\BroadcastController@sendNotificationToDevice',
        'as' => 'admin.broadcast.only.user',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    /* broadcast */
	
	/* paypal subscription manual updates */
	Route::get('subscription/update-user-subscription/{subscription_id}', [
        'uses' => 'Reports\PaypalSubscriptionUpdateController@update_paypal_recurring_responseManual',
        'as' => 'admin.subscription.update-status',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	/* Feedback routes*/
	
	

    Route::get('/feedback', [
        'uses' => 'Admin\FeedbackController@index',
        'as' => '/feedback',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);


    Route::get('/show-feedback', [
        'uses' => 'Admin\FeedbackController@show_feedback',
        'as' => '/show-feedback',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);


    Route::get('/feedback-noReply', [
        'uses' => 'Admin\FeedbackController@show_noReply',
        'as' => '/feedback-noReply',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/feedback/view/{id}/{slug}', [
        'uses' => 'Admin\FeedbackController@show_full_feedback',
        'as' => '/feedback/view/{id}/{slug}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/feedback-reply', [
        'uses' => 'Admin\FeedbackController@feedback_reply',
        'as' => 'feedback.reply',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/search-feedback', [
        'uses' => 'Admin\FeedbackController@search_feedback',
        'as' => 'feedback.search',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/search-feedback', [
        'uses' => 'Admin\FeedbackController@search_feedback',
        'as' => 'feedback.search',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);	
	/* Feedback routes */

    /* Designer invitation */
    Route::get('invite-designers', [
        'uses' => 'Admin\Admincontroller@UserInvitation',
        'as' => 'admin.invite.designers',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    Route::post('send-invite', [
        'uses' => 'Admin\Admincontroller@SendInvitation',
        'as' => 'admin.invite.send',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    /* Designer invitation */


    /* support ticket */
    Route::get('support', [
        'uses' => 'Admin\SupportController@index',
        'as' => 'admin.support',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
    
    Route::get('/support/{ticket_id}/show', 'Admin\SupportController@show_ticket');
    Route::get('/support/reply/{ticket_id}', 'Admin\SupportController@support_reply');
    Route::post('/saveReply', 'Admin\SupportController@saveReply')->name('AdminsaveReply');
    Route::post('/support/reinitiate-ticket', 'Admin\SupportController@reInitiate_ticket')->name('AdminreInitiateTcket');
    Route::post('/support/uploadImage', 'Admin\SupportController@upload_image');
    Route::post('/support/removeImage', 'Admin\SupportController@remove_image');
    Route::post('/support/close-ticket','Admin\SupportController@close_ticket')->name('admin.closeTicket');
    Route::post('/support/resolve-ticket','Admin\SupportController@resolve_ticket')->name('admin.resolveTicket');
    /* support ticket */


});
