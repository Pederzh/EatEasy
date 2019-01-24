<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
	/* HOME */
    Route::get('/', 'HomeController@index');

    /* routes per il login ed il logout */
	Route::get('login', 'Auth\AuthController@showLoginForm');
	Route::post('login', 'Auth\AuthController@Login');
	Route::get('logout', 'Auth\AuthController@logout');

    /* routes per il recupero della password */
	Route::post('password/email','Auth\PasswordController@sendResetLinkEmail');
	Route::post('password/reset','Auth\PasswordController@reset');
	Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');

    /* routes per la registrazione  */
	Route::get('register', 'RegistrationController@register');
	Route::post('register', 'RegistrationController@postRegister');
	Route::get('register/confirm/{token}', 'RegistrationController@confirmEmail');

    /* routes per il completamento della registrazione */
    /*Esercenti*/
    Route::get('/completeregistrationEsercente', 'EsercentiController@showCompleteRegistration');
    Route::post('/esercente/salvaCompleteRegistration', 'EsercentiController@storeCompleteRegistration' );
    Route::get('/questionesercente', 'EsercentiController@showQuestion');
    Route::post('/esercente/storeQuestion', 'EsercentiController@storeQuestion');
    Route::get('/ristorante/{id}', 'EsercentiController@show');
    Route::get('/punteggio', 'EsercentiController@storeScore');
    /*Utenti*/
    Route::get('/completeregistrationUtente', 'UtentiController@showCompleteRegistration');
    Route::post('/utente/salvaCompleteRegistration', 'UtentiController@storeCompleteRegistration' );
    Route::get('/questionutente', 'UtentiController@showQuestion');
    Route::post('/utente/storeQuestion', 'UtentiController@storeQuestion');


    /* route per l'area riservata di ogni user */
    Route::get('/reservedarea','UsersController@showReservedArea');

    /* route per la ricerca */
    /* se viene chiamato dalla barra di ricerca rapida nella GET ci sarà il luogo, dalla NAVBAR niente */
    Route::get('/ricerca', 'RicercaController@showRicerca');
    /* pagina singola ristorante */
    Route::get('ristorante/{id}', 'EsercentiController@showRestaurant');

    /* pagine statiche */
    Route::get('/chisiamo', 'HomeController@chiSiamo');

    Route::get('/contatti', 'HomeController@contatti');
    
    /*autocomplete*/
    Route::get('getdata', 'UtentiController@autocomplete');
    Route::get('getdata', 'EsercentiController@autocomplete');
    
    /*retrieve dell'immagine*/
    Route::get('getImg/{id}/{img}','UsersController@takeImg');
    Route::get('getImgRestaurant/{id}/{img}','UsersController@takeImgRestaurant');

});