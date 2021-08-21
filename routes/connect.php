<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'web','prefix' => 'connect'], function () {
	/* Timeline controller */
	Route::get('/','Connect\TimelineController@index');
	Route::get('getData/{id}','Connect\TimelineController@show_more');

	/* Timeline Controller */

	/* Connections controller */
	Route::get('my-connections','Connect\ConnectionsController@index');
	Route::post('filter-my-connections','Connect\ConnectionsController@filter_my_connections');
	Route::get('find-connections','Connect\ConnectionsController@find_connections');
	Route::post('filter-find-connections','Connect\ConnectionsController@filter_find_connections');
	Route::post('sendFriendRequest','Connect\ConnectionsController@sendFriendRequest');
	Route::post('cancelFriendRequest','Connect\ConnectionsController@cancelFriendRequest');
	Route::post('removeFriend','Connect\ConnectionsController@removeFriend');
	Route::post('acceptRequest','Connect\ConnectionsController@acceptRequest');
	Route::get('friend-requests','Connect\ConnectionsController@friend_requests');
	Route::post('rejectFriendRequest','Connect\ConnectionsController@rejectFriendRequest');
	Route::get('find-connections-ajax','Connect\ConnectionsController@friend_requests_ajax');
	Route::get('show-suggested-connections','Connect\ConnectionsController@show_suggested_connections');

	Route::post('follow','Connect\ConnectionsController@follow_user');
	Route::post('unfollow','Connect\ConnectionsController@unfollow_user');
	Route::get('markAsRead','Connect\ConnectionsController@markAsRead');

	Route::get('profile/{username}/{id}','Connect\ConnectionsController@user_profile');
	Route::get('myprofile','Connect\ConnectionsController@my_profile');
	Route::post('addAboutme','Connect\ConnectionsController@profile_addAboutme');
	Route::get('getSkillset','Connect\ConnectionsController@profile_getSkillset');
	Route::get('editSkillset','Connect\ConnectionsController@profile_editSkillset');
	Route::post('addskillSet','Connect\ConnectionsController@profile_addskillSet');
	Route::get('getInterest','Connect\ConnectionsController@profile_getInterest');
	Route::get('editInterest','Connect\ConnectionsController@profile_editInterest');
	Route::post('addInterest','Connect\ConnectionsController@profile_addInterest');

	Route::get('getDetails','Connect\ConnectionsController@profile_getDetails');
	Route::get('editDetails','Connect\ConnectionsController@profile_editDetails');
	Route::post('addDetails','Connect\ConnectionsController@profile_addDetails');

	Route::post('addPost','Connect\TimelineController@timeline_addDetails');
	Route::post('updatePost','Connect\TimelineController@timeline_updateDetails');
	Route::post('addLike','Connect\TimelineController@timeline_addLike');
	Route::post('unLikePost','Connect\TimelineController@timeline_unLikePost');
	Route::post('deletePost','Connect\TimelineController@timeline_deletePost');
	Route::post('addComment','Connect\TimelineController@timeline_addComment');
	Route::post('UpdateComment','Connect\TimelineController@timeline_UpdateComment');
	Route::post('savePrivacy','Connect\TimelineController@timeline_savePrivacy');

	Route::get('allCommentsPost/{id}','Connect\TimelineController@timeline_allCommentsPost');

	Route::get('allCommentsPhotos/{id}','Connect\TimelineController@allCommentsPhotos');
    Route::post('deleteComment','Connect\TimelineController@timeline_deleteComment');
	Route::get('deleteImage/{id}','Connect\TimelineController@deleteImage');

    Route::post('addCommentLike','Connect\TimelineController@timeline_addCommentLike');
    Route::post('unLikeComment','Connect\TimelineController@timeline_unLikeComment');

	Route::get('showAddPost','Connect\TimelineController@showAddPost');
	Route::get('editAddPost/{id}','Connect\TimelineController@editAddPost');

	Route::post('imageUpload','Connect\TimelineController@imageUpload');
	Route::get('users','Connect\TimelineController@users');
	Route::get('gallery','Connect\ConnectionsController@user_gallery');


	Route::post('profile-picture','Connect\ConnectionsController@profile_picture');
	/* Connections controller */

	Route::get('notifications/timeline/{id}','Connect\TimelineController@post_notification');
});
