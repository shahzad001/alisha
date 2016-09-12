<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
// API Routes

// Routing for users
Route::group(['prefix' => 'api'],function()
{
    Route::group(['prefix' => 'user'],function()
    {
        Route::get('',['uses' => 'UserController@allUsers',]);
        Route::get('{id}',['uses' => 'UserController@getUser']);
        Route::post('',['uses' => 'UserController@registerUser']);
        Route::post('update/{id}',['uses' => 'UserController@updateUser']);
        Route::delete('{id}',['uses' => 'UserController@deleteUser']);
        Route::post('changepassword',['uses' => 'UserController@changePassword']);
        Route::post('recoverpassword',['uses' => 'UserController@recoverPassword']);
        Route::post('facebooklogin',['uses' => 'UserController@loginWithFacebook']);
        Route::post('showRewards',['uses' => 'UserController@showRewards']);
        Route::post('comment',['uses' => 'UserController@addComments']);
        Route::post('commentlist',['uses' => 'UserController@getCommentsLists']);
        Route::post('addradius',['uses' => 'UserController@addUserSetting']);
        Route::post('getradius',['uses' => 'UserController@getUserSetting']);
    });
});
// Routing for venues
Route::group(['prefix' => 'api'],function()
{
    Route::group(['prefix' => 'venue'],function()
    {
        Route::post('lists/{user_id}',['uses' => 'VenuesController@getVenue']);
        Route::post('lists',['uses' => 'VenuesController@allVenues']);
        Route::post('',['uses' => 'VenuesController@registerVenue']);
        Route::put('{id}',['uses' => 'VenuesController@updateVenue']);
        Route::delete('{id}',['uses' => 'VenuesController@deleteVenue']);
        Route::post('venueRating',['uses' => 'Venue_RatingController@getRating']);
        Route::post('venueFavourites',['uses' => 'VenuesController@addToFavourite']);
        Route::post('venueUnFavourites',['uses' => 'VenuesController@removeFromFavourite']);
        Route::post('likeunlike',['uses' => 'VenuesController@likeUnlike']);
        Route::post('likeUnlikeVenue',['uses' => 'VenuesController@likeUnlikeVenue']);
        Route::post('venuesFavouritelist/{user_id}',['uses' => 'VenuesController@getFavouriteLists']);
        Route::post('titles/{venue_id}',['uses' => 'VenuesController@getEventsLists']);
        Route::post('calendarCount',['uses' => 'VenuesController@calendarCount']);
        Route::post('eventsByDate',['uses' => 'VenuesController@eventsByDate']);


    });
});

// Routing for events
Route::group(['prefix' => 'api'],function()
{
    Route::group(['prefix' => 'event'],function()
    {
        Route::post('lists/{user_id}',['uses' => 'EventController@getEvent']);
        Route::post('lists',['uses' => 'EventController@allEvents']);
        Route::post('eventRating',['uses' => 'Event_RatingController@getRating']);
        Route::post('eventFavourites',['uses' => 'EventController@addToFavourites']);
        Route::post('eventUnFavourites',['uses' => 'EventController@removeFromFavourite']);
        Route::post('eventLikeUnlike',['uses' => 'EventController@eventLikeUnlike']);
        Route::post('likeUnlikeEvent',['uses' => 'EventController@likeUnlikeEvent']);
        Route::post('eventsFavouritelist/{user_id}',['uses' => 'EventController@getEventsFavouriteLists']);
        Route::get('',['uses' => 'EventController@allEvents',]);
        Route::post('',['uses' => 'EventController@registerEvent']);
        Route::put('{id}',['uses' => 'EventController@updateEvent']);
        Route::delete('{id}',['uses' => 'EventController@deleteEvent']);

    });
});

Route::group(['prefix' => 'api'],function()
{
    Route::group(['prefix' => 'staff'],function()
    {
        Route::post('lists/{id}',['uses' => 'StaffController@getStaff']);
        Route::post('createStaff',['uses' => 'StaffController@createStaff']);
        Route::post('assignStaff',['uses' => 'assign_remove_staffController@assignStaff']);
        Route::post('venueslists/{user_id}',['uses' => 'StaffController@getVenuesLists']);
        Route::post('getEventLists/{user_id}',['uses' => 'StaffController@getEventLists']);
        Route::post('availability',['uses' => 'StaffController@staffAvailability']);
        Route::post('testMail',['uses' => 'StaffController@testMail']);
    });
});



// Login Route
       Route::post('user/login', ['uses' => 'UserController@verifyLogin']);

// Login with Face
       Route::post('user/login/facebook', ['uses' => 'UserController@loginWithFacebook']);
       Route::post('getFavouriteLists', ['uses' => 'ListController@getFavouriteLists']);
       Route::post('getUnFavouriteLists', ['uses' => 'ListController@getUnFavouriteLists']);
       Route::post('inviteFriendAward/{user_id}', ['uses' => 'UserController@inviteFriends']);

       Route::post('register', 'RegistrationController@postRegister');

Route::group(['prefix' => 'api'],function()
{
    Route::post('imageupload',['uses' => 'VenuesController@uploadImages']);
    Route::post('imageslists',['uses' => 'VenuesController@getImagesLists']);
});






