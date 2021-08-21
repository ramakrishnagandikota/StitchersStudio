<?php 

Route::group(['middleware' => ['web','roles'],'prefix' => 'designer'], function () {
	
	Route::get('/main/dashboard', [
        'uses' => 'Designer\Temp\TDesignercontroller@index',
        'as' => '/dashboard',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::get('/main/my-patterns', [
        'uses' => 'Designer\Temp\TDesignercontroller@my_patterns',
        'as' => 'designer.main.my.patterns',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::get('/main/view/pattern/{id}/{slug}', [
        'uses' => 'Designer\Temp\TDesignercontroller@pattern_details',
        'as' => 'designer.main.my.patterns.{id}',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);
	
	Route::post('/main/change-password', [
        'uses' => 'Designer\Temp\TDesignercontroller@change_password',
        'as' => 'designer.main.change.password',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);
	
	Route::post('/main/change-designer-status', [
        'uses' => 'Designer\Temp\TDesignercontroller@update_product_designer_review_status',
        'as' => 'designer.main.change.designer.status',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);
	
	
	Route::get('/my-patterns','Designer\PatternsController@my_patterns');
    Route::get('/create-pattern','Designer\PatternsController@create_pattern');
    Route::post('/save-pattern','Designer\PatternsController@save_pattern');
    Route::post('/upload-pattern-images','Designer\PatternsController@upload_pattern_images');
    Route::post('/upload-pattern-images','Designer\PatternsController@upload_pattern_images');
    Route::get('/pattern/{id}/edit','Designer\PatternsController@edit_pattern');
    Route::post('/check-pattern-status','Designer\PatternsController@get_work_status');
    Route::post('/upload-patternInstrctionsFile','Designer\PatternsController@upload_designer_pattern_instructions');
    Route::post('/upload-designer-recomondation-images','Designer\PatternsController@upload_designer_recomondation_images');
    Route::post('/update-pattern-step','Designer\PatternsController@update_pattern_step');
    Route::post('/delete-pattern-images','Designer\PatternsController@deletePatternImages');
    Route::post('/make-image-default','Designer\PatternsController@make_image_default');
    Route::post('/update-all-pattern-data','Designer\PatternsController@update_full_product_data');
    Route::get('/delete-pattern-reference-image/{id}','Designer\PatternsController@deleteReferenceImages');
    Route::get('/delete-needles/{id}','Designer\PatternsController@deleteNeedles');
    Route::get('/delete-yarn-image/{id}','Designer\PatternsController@deleteYarnRecommmendationsImages');
    Route::get('/delete-yarn/{id}','Designer\PatternsController@deleteYarnRecommmendations');
    Route::get('/change-pattern-status/{id}','Designer\PatternsController@change_pattern_status');

    Route::get('/paypal','Designer\Designercontroller@paypal_credentials');
    Route::post('/update-paypal-credentials','Designer\Designercontroller@update_paypal_credentials');
	
	/* sales routes */
    Route::get('/sales','Designer\SalesController@index');
    Route::match(array('GET','POST'),'/salesData','Designer\SalesController@getChartData');
    Route::match(array('GET','POST'),'/salesPieData','Designer\SalesController@getPieChartData');

	/* Groups routes */
    Route::get('/groups/categories','Designer\GroupsController@get_group_categories');
    Route::get('groups/getAllCategories','Designer\GroupsController@get_all_group_categories');
    Route::get('groups/category/add','Designer\GroupsController@group_add_categories');
    Route::post('groups/category/create','Designer\GroupsController@group_save_categories');
    Route::post('groups/categories/update','Designer\GroupsController@group_categories_update');
    Route::post('groups/categories/delete','Designer\GroupsController@delete_group_category');

    Route::get('/groups','Designer\GroupsController@index');
    Route::get('/create-group','Designer\GroupsController@create_group');
    Route::post('/createGroup','Designer\GroupsController@save_group');
    Route::get('/groups/{id}/show','Designer\GroupsController@show_group');
    Route::get('/groups/{id}/edit','Designer\GroupsController@edit_group');
    Route::post('/updateGroup','Designer\GroupsController@update_group');
    Route::post('/deleteGroup','Designer\GroupsController@delete_group');
    Route::post('/groups/getProductImage','Designer\GroupsController@getProductImage');

    Route::get('/group-broadcast','Designer\GroupsController@broadcast_message');
    Route::post('/sendGroupInvitation','Designer\GroupsController@sendInvitation');
    Route::post('/sendGroupMessage','Designer\GroupsController@sendGroupBroadcastMssage');
    Route::post('/broadcastmsgToUsers','Designer\GroupsController@broadcastmsgToUsers');
    Route::post('/groups/openBroadcastMessage','Designer\GroupsController@openBroadcastMessage');
    Route::post('/deleteGroupUser','Designer\GroupsController@deleteGroupUser');
    Route::post('/getGroupInformation','Designer\GroupsController@getGroupInformation');
    Route::post('/ignoreGroupInvitationequest','Designer\GroupsController@ignoreGroupInvitationequest');
    Route::post('/acceptGroupInvitationequest','Designer\GroupsController@acceptGroupInvitationequest');

    Route::get('/groups/{id}/faq','Designer\GroupsController@show_group_faq');
    Route::get('/groups/{id}/getFaqCategories','Designer\GroupsController@getFaqCategories');
    Route::post('/groups/faq/categories/{id}/update','Designer\GroupsController@categories_update');
    Route::get('/groups/{id}/faq/category/add','Designer\GroupsController@add_group_faq_category');
    Route::post('/groups/faq/category/create','Designer\GroupsController@create_group_faq_category');
    Route::post('/groups/faq/category/delete','Designer\GroupsController@delete_group_faq_category');

    Route::get('/groups/{id}/faq/categories','Designer\GroupsController@get_all_group_faq_categories');
    Route::post('/groups/saveFAQ','Designer\GroupsController@saveFAQ');
    Route::post('/groups/faq/edit','Designer\GroupsController@edit_group_faq');
    Route::post('/groups/faq/updateFAQ','Designer\GroupsController@update_group_faq');
    Route::post('/groups/faq/delete','Designer\GroupsController@delete_group_faq');
    Route::get('/groups/{id}/faq/getCategoriesData','Designer\GroupsController@getGroupsFAQCategoriesSideMenu');
    Route::get('/groups/faq/{id}/show','Designer\GroupsController@group_faq_full_view');

    /* community toutes */
    Route::get('groups/{group_id}/community','Designer\GroupsController@show_group_community');
    Route::get('groups/{group_id}/community/getMore','Designer\GroupsController@show_more');
    Route::get('groups/{group_id}/showAddPost','Designer\GroupsController@showAddPost');
    Route::post('imageUpload','Designer\GroupsController@imageUpload');
    Route::post('groups/{group_id}/addPost','Designer\GroupsController@timeline_addDetails');
    Route::get('groups/{group_id}/editAddPost/{id}','Designer\GroupsController@editAddPost');
    Route::post('groups/{group_id}/updatePost','Designer\GroupsController@timeline_updateDetails');
    Route::post('groups/{group_id}/deletePost','Designer\GroupsController@timeline_deletePost');
    Route::post('groups/{group_id}/addLike','Designer\GroupsController@timeline_addLike');
    Route::post('groups/{group_id}/unLikePost','Designer\GroupsController@timeline_unLikePost');
    Route::post('groups/{group_id}/addComment','Designer\GroupsController@timeline_addComment');
    Route::get('groups/{group_id}/deleteImage/{id}','Designer\GroupsController@deleteImage');
    Route::post('groups/{group_id}/addCommentLike','Designer\GroupsController@timeline_addCommentLike');
    Route::post('groups/{group_id}/unLikeComment','Designer\GroupsController@timeline_unLikeComment');
    Route::post('groups/{group_id}/UpdateComment','Designer\GroupsController@timeline_UpdateComment');
    Route::post('groups/{group_id}/deleteComment','Designer\GroupsController@timeline_deleteComment');
});