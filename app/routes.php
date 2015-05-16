<?php

Route::group(array('prefix' => 'v1'), function () {
    Route::options('messages', ['as' => 'messages.options', 'uses' => '\Exapp\Controllers\MessageController@optionsForCollection']);

    Route::post('messages', ['as' => 'messages.post', 'uses' => '\Exapp\Controllers\MessageController@store']);

    Route::match(['GET', 'PATCH', 'PUT', 'DELETE'], 'messages', ['as' => 'messages.guard', 'uses' => '\Exapp\Controllers\MessageController@guardMethods']);

    Route::options('countries', ['as' => 'countries.options', 'uses' => '\Exapp\Controllers\CountryController@optionsForCollection']);

    Route::get('countries', ['as' => 'countries.get', 'uses' => '\Exapp\Controllers\CountryController@index']);

    Route::match(['POST', 'PATCH', 'PUT', 'DELETE'], 'countries', ['as' => 'countries.guard', 'uses' => '\Exapp\Controllers\CountryController@guardMethods']);
});
