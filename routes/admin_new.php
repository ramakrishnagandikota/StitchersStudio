<?php

Route::group(['middleware' => 'web','prefix' => 'adminnew'], function () {

	Route::get('/', [
        'uses' => 'AdminNew\AdminController@index',
        'as' => '/',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/feedback', [
        'uses' => 'AdminNew\FeedbackController@index',
        'as' => '/feedback',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);


    Route::get('/show-feedback', [
        'uses' => 'AdminNew\FeedbackController@show_feedback',
        'as' => '/show-feedback',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);


    Route::get('/feedback-noReply', [
        'uses' => 'AdminNew\FeedbackController@show_noReply',
        'as' => '/feedback-noReply',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/feedback/view/{id}/{slug}', [
        'uses' => 'AdminNew\FeedbackController@show_full_feedback',
        'as' => '/feedback/view/{id}/{slug}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/feedback-reply', [
        'uses' => 'AdminNew\FeedbackController@feedback_reply',
        'as' => 'feedback.reply',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/search-feedback', [
        'uses' => 'AdminNew\FeedbackController@search_feedback',
        'as' => 'feedback.search',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/search-feedback', [
        'uses' => 'AdminNew\FeedbackController@search_feedback',
        'as' => 'feedback.search',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/formulas-list', [
        'uses' => 'AdminNew\FormulasController@index',
        'as' => 'formulas.list',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/pattern-templates-list', [
        'uses' => 'AdminNew\FormulasController@view_pattern_template',
        'as' => 'pattern.templates.list',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/check-template-name', [
        'uses' => 'AdminNew\FormulasController@check_template_name',
        'as' => 'check.template.name',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-template/save', [
        'uses' => 'AdminNew\FormulasController@save_pattern_template',
        'as' => 'create.pattern.save',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/pattern-template/create', [
        'uses' => 'AdminNew\FormulasController@create_pattern_template',
        'as' => 'create.pattern.create',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/pattern-template/{id}/show', [
        'uses' => 'AdminNew\FormulasController@show_pattern_template',
        'as' => 'template.pattern.{id}.show',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-template/add-data', [
        'uses' => 'AdminNew\FormulasController@add_template_data',
        'as' => 'template.pattern.add.data',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/check-section-name', [
        'uses' => 'AdminNew\FormulasController@check_section_name',
        'as' => 'check.section.name',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-template/add-section', [
        'uses' => 'AdminNew\FormulasController@pattern_template_add_section',
        'as' => 'template.pattern.add.section',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/get-all-sections/{pattern_template_id}', [
        'uses' => 'AdminNew\FormulasController@get_all_sections',
        'as' => 'get.all.sections.{pattern_template_id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/get-new-sections/{pattern_template_id}', [
        'uses' => 'AdminNew\FormulasController@get_new_section',
        'as' => 'get.new.sections.{pattern_template_id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/get-function-attributes', [
        'uses' => 'AdminNew\FormulasController@get_function_attributes',
        'as' => 'get.function.attributes',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/add-snippet', [
        'uses' => 'AdminNew\FormulasController@add_snippet',
        'as' => 'save.snippet.data',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-snippet', [
        'uses' => 'AdminNew\FormulasController@update_snippet',
        'as' => 'update.snippet.data',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-delete-section', [
        'uses' => 'AdminNew\FormulasController@delete_section',
        'as' => 'pattern.template.delete.section',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-delete-snippet', [
        'uses' => 'AdminNew\FormulasController@delete_snippet',
        'as' => 'pattern.template.delete.snippet',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-delete-template', [
        'uses' => 'AdminNew\FormulasController@delete_pattern_template',
        'as' => 'delete.pattern.template',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/duplicate-template', [
        'uses' => 'AdminNew\FormulasController@duplicate_pattern_template',
        'as' => 'duplicate.template',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/pattern-template/preview', [
        'uses' => 'AdminNew\FormulasController@preview_pattern_template',
        'as' => 'pattern.template.preview',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/measurements', [
        'uses' => 'AdminNew\MeasurementsController@index',
        'as' => 'admin.measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/measurements/check-measurement-name', [
        'uses' => 'AdminNew\MeasurementsController@check_measurement_name',
        'as' => 'check.measurement.name',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/measurements/create-measurement-profile', [
        'uses' => 'AdminNew\MeasurementsController@create_measurement_profile',
        'as' => 'create.measurement.profile',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/measurements/{id}/show', [
        'uses' => 'AdminNew\MeasurementsController@view_measurement_profile',
        'as' => 'measurements.{id}.show',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/measurements/update', [
        'uses' => 'AdminNew\MeasurementsController@update_measurement_profile',
        'as' => 'measurements.update',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-section-name', [
        'uses' => 'AdminNew\FormulasController@update_section_name',
        'as' => 'update.section.name',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/template-add-yarndetails', [
        'uses' => 'AdminNew\FormulasController@template_add_yarn_details',
        'as' => 'template.yarndetails.add.data',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/template-get-yarn-data/{id}', [
        'uses' => 'AdminNew\FormulasController@template_get_yarn_details',
        'as' => 'template.get.yarn.data.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/template-delete-yarn-data/{id}', [
        'uses' => 'AdminNew\FormulasController@template_delete_yarn_details',
        'as' => 'template.delete.yarn.data.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('pattern-specific-measurements', [
        'uses' => 'AdminNew\MeasurementsController@pattern_specific_measurements',
        'as' => 'pattern.specific.measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('add-pattern-specific-measurements', [
        'uses' => 'AdminNew\MeasurementsController@add_pattern_specific_measurements',
        'as' => 'add.pattern.specific.measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    /*** starts users ***/

    Route::get('cususers-view', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_view',
        'as' => 'cususers.view',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('cususers-view/{status}', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_view',
        'as' => 'cususers-view/{status}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('cususers-add', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_add',
        'as' => 'cususers.add',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('cususers-insert', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_insert',
        'as' => 'cususers.insert',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('cususers-edit/{id}', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_edit',
        'as' => 'cususers.edit.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('cususer-delete/{id}', [
        'uses' => 'AdminNew\Customerusercontroller@cususer_delete',
        'as' => 'cususer.delete.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('cususers-update', [
        'uses' => 'AdminNew\Customerusercontroller@cususers_update',
        'as' => 'cususers.update',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('manage/users-role', [
        'uses' => 'AdminNew\Customerusercontroller@manage_users_role',
        'as' => 'manage.users.role',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/assign-roles', [
        'uses' => 'AdminNew\Customerusercontroller@postAdminAssignRoles',
        'as' => 'admin.assign',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);


    Route::get('users/{id}/measurements', [
        'uses' => 'AdminNew\Customerusercontroller@users_measurements',
        'as' => 'users.{id}.measurements',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('users/{id}/projects', [
        'uses' => 'AdminNew\Customerusercontroller@users_projects',
        'as' => 'users.{id}.projects',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('tokenUrl',function(){
        return true;
    });

    /* broadcast */

    Route::get('broadcast', [
        'uses' => 'AdminNew\BroadcastController@broadcast',
        'as' => 'broadcast',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('broadcast/notify', [
        'uses' => 'AdminNew\BroadcastController@broadcast_notify',
        'as' => 'broadcast.notify',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('broadcast/user', [
        'uses' => 'AdminNew\BroadcastController@broadcast_user',
        'as' => 'broadcast.user',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
/* new formula requests */
    Route::get('new-formula/requests', [
        'uses' => 'AdminNew\FormulasController@new_formula_requests',
        'as' => 'admin.new.formula.requests',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('edit/new-formula-request/{id}', [
        'uses' => 'AdminNew\FormulasController@edit_new_formula_requests',
        'as' => 'admin.edit.formula.requests.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('new-formula-request/completed', [
        'uses' => 'AdminNew\FormulasController@completed_new_formula_requests',
        'as' => 'admin.completed.new.formula',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/new-formula-request/work-status', [
        'uses' => 'AdminNew\FormulasController@get_formula_work_status',
        'as' => 'adminnew.newFormula.workStatus',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/output-variables', [
        'uses' => 'AdminNew\FormulasController@output_variables',
        'as' => 'adminnew.outputVariables',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/edit-outpurvariables/{id}', [
        'uses' => 'AdminNew\FormulasController@edit_output_variables',
        'as' => 'adminnew.edit.outputVariables',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-outpurvariables', [
        'uses' => 'AdminNew\FormulasController@update_output_variables',
        'as' => 'adminnew.updateOutputVariables',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/sample-instructions', [
        'uses' => 'AdminNew\FormulasController@sample_instructions',
        'as' => 'adminnew.sampleInstructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/edit-sampleinstructions/{id}', [
        'uses' => 'AdminNew\FormulasController@edit_sample_instructions',
        'as' => 'adminnew.edit.sampleinstructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-sampleinstructions', [
        'uses' => 'AdminNew\FormulasController@update_sample_instructions',
        'as' => 'adminnew.updateSampleInstructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/hierarchy', [
        'uses' => 'AdminNew\FormulasController@show_hierarchy',
        'as' => 'adminnew.hierarchy',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/deleteHierarchy/{id}', [
        'uses' => 'AdminNew\FormulasController@delete_hierarchy',
        'as' => 'adminnew.deleteHierarchy.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/addHierarchy', [
        'uses' => 'AdminNew\FormulasController@add_hierarchy',
        'as' => 'adminnew.addHierarchy',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	/* Product Management */

    Route::get('/products', [
        'uses' => 'AdminNew\ProductsController@products_list',
        'as' => 'adminnew.products',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/add-pattern/{pattern_type}', [
        'uses' => 'AdminNew\ProductsController@add_pattern',
        'as' => 'adminnew.addPattern.{pattern_type}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/edit-pattern/{id}/{slug}', [
        'uses' => 'AdminNew\ProductsController@edit_pattern',
        'as' => 'adminnew.editPattern.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/upload-admin-pattern-images', [
        'uses' => 'AdminNew\ProductsController@upload_admin_pattern_images',
        'as' => 'upload.admin.pattern.images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/upload-admin-recomondation-images', [
        'uses' => 'AdminNew\ProductsController@upload_admin_recomondation_images',
        'as' => 'upload.admin.recomondation.images',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/upload-admin-pattern-instructions', [
        'uses' => 'AdminNew\ProductsController@upload_admin_pattern_instructions',
        'as' => 'upload.admin.pattern.instructions',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/add-traditional-pattern', [
        'uses' => 'AdminNew\ProductsController@add_traditional_pattern',
        'as' => 'adminnew.add.traditional.pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-traditional-pattern', [
        'uses' => 'AdminNew\ProductsController@update_traditional_pattern',
        'as' => 'adminnew.update.traditional.pattern',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/deleteYarnRecommmendations/{id}', [
        'uses' => 'AdminNew\ProductsController@deleteYarnRecommmendations',
        'as' => 'adminnew.deleteYarnRecommmendations',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::get('/delete-yarn-image/{id}', [
        'uses' => 'AdminNew\ProductsController@deleteYarnRecommmendationsImages',
        'as' => 'adminnew.delete.yarn.image.{id}',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::get('/delete-pattern-image/{id}', [
        'uses' => 'AdminNew\ProductsController@deletePatternImages',
        'as' => 'adminnew.delete.pattern.image.{id}',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::get('/deleteNeedles/{id}', [
        'uses' => 'AdminNew\ProductsController@deleteNeedles',
        'as' => 'adminnew.deleteNeedles',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    Route::post('/make-image-default', [
        'uses' => 'AdminNew\ProductsController@make_image_default',
        'as' => 'adminnew.make.image.default',
        'middleware' => 'roles',
        'roles' => ['Designer']
    ]);

    /* Product Management */
	
	/* Routs only for rama krishna use */
	Route::get('/getAllData/{id}', [
        'uses' => 'AdminNew\FormulasController@get_all_data',
        'as' => 'adminnew.getAllData',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/submitAllData', [
        'uses' => 'AdminNew\FormulasController@submit_all_data',
        'as' => 'adminnew.submitAllData',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/remove-added-functions/{pattern_template_id}', [
        'uses' => 'AdminNew\FormulasController@remove_added_functions',
        'as' => 'adminnew.remove.added.functions.{pattern_template_id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/create-add-update-function', [
        'uses' => 'AdminNew\FormulasController@create_new_update_formula_page',
        'as' => 'adminnew.create.add.update.function',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::get('/create-add-update-function/{id}', [
        'uses' => 'AdminNew\FormulasController@create_new_update_formula_page',
        'as' => 'adminnew.create.add.update.function.{id}',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/update-formula', [
        'uses' => 'AdminNew\FormulasController@update_formula_page',
        'as' => 'adminnew.update.formula',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);

    Route::post('/create-formula', [
        'uses' => 'AdminNew\FormulasController@create_formula_page',
        'as' => 'adminnew.create.formula',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
	Route::get('/change-function-name', [
        'uses' => 'AdminNew\FormulasController@update_function_name_csv',
        'as' => 'adminnew.change.name',
        'middleware' => 'roles',
        'roles' => ['Admin']
    ]);
	
/* Routs only for rama krishna use */

});
