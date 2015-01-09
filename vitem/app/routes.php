<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(['before' => 'guest'], function () {

	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
	Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

});

Route::group(['before' => 'auth'], function () {

	Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@dashboard']);

	Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

	Route::resource('stores', 'StoresController');

	Route::resource('users', 'UsersController');

	Route::resource('clients', 'ClientsController');

	Route::resource('suppliers', 'SuppliersController');

	Route::resource('products', 'ProductsController');

	Route::resource('packs', 'PacksController');

	Route::resource('sales', 'SalesController');

	Route::resource('sale_payments', 'SalePaymentsController');

	Route::get('sale_payments/create/{sale_id}' , ['as' => 'sale_payments.create.sale_id', 'uses' => 'SalePaymentsController@create']);

	Route::resource('commissions', 'CommissionsController');

	Route::get('commissions/create/{sale_id}' , ['as' => 'commissions.create.sale_id', 'uses' => 'CommissionsController@create']);

	Route::resource('destinations', 'DestinationsController');

	Route::resource('deliveries', 'DeliveriesController');

	Route::get('deliveries/create/{sale_id}' , ['as' => 'deliveries.create.sale_id', 'uses' => 'DeliveriesController@create']);

	Route::resource('expenses', 'ExpensesController');

	Route::resource('settings', 'SettingsController');

	Route::get('API/users' , ['as' => 'usersAPI', 'uses' => 'UsersController@API']);

	Route::get('API/users/{method}' , ['as' => 'usersAPI', 'uses' => 'UsersController@API']);

	Route::get('API/clients' , ['as' => 'clientsAPI', 'uses' => 'ClientsController@API']);

	Route::get('API/clients/{method}' , ['as' => 'clientsAPI', 'uses' => 'ClientsController@API']);

	Route::get('API/products/' , ['as' => 'productsAPI', 'uses' => 'ProductsController@API']);

	Route::get('API/products/{method}' , ['as' => 'productsAPI', 'uses' => 'ProductsController@API']);

	Route::get('API/suppliers/' , ['as' => 'suppliersAPI', 'uses' => 'SuppliersController@API']);

	Route::get('API/suppliers/{method}' , ['as' => 'suppliersAPI', 'uses' => 'SuppliersController@API']);

	Route::get('API/packs/' , ['as' => 'packsAPI', 'uses' => 'PacksController@API']);

	Route::get('API/packs/{method}' , ['as' => 'packsAPI', 'uses' => 'PacksController@API']);

	Route::get('API/sales/' , ['as' => 'salesAPI', 'uses' => 'SalesController@API']);

	Route::get('API/sales/{method}' , ['as' => 'salesAPI', 'uses' => 'SalesController@API']);

	Route::get('API/commissions/' , ['as' => 'commissionsAPI', 'uses' => 'CommissionsController@API']);

	Route::get('API/commissions/{method}' , ['as' => 'commissionsAPI', 'uses' => 'CommissionsController@API']);

	Route::get('API/destinations/' , ['as' => 'destinationsAPI', 'uses' => 'DestinationsController@API']);

	Route::get('API/destinations/{method}' , ['as' => 'destinationsAPI', 'uses' => 'DestinationsController@API']);

	Route::get('API/deliveries/' , ['as' => 'deliveriesAPI', 'uses' => 'DeliveriesController@API']);

	Route::get('API/deliveries/{method}' , ['as' => 'deliveriesAPI', 'uses' => 'DeliveriesController@API']);

	Route::get('API/expenses/' , ['as' => 'expensesAPI', 'uses' => 'ExpensesController@API']);

	Route::get('API/expenses/{method}' , ['as' => 'expensesAPI', 'uses' => 'ExpensesController@API']);

	Route::get('API/settings/' , ['as' => 'settingsAPI', 'uses' => 'SettingsController@API']);

	Route::get('API/settings/{method}' , ['as' => 'settingsAPI', 'uses' => 'SettingsController@API']);

	Route::get('reports/sales' , ['as' => 'reports.sales', 'uses' => 'ReportsController@sales']);

	Route::post('reports/generate_xls' , ['as' => 'reports.generate_xls', 'uses' => 'ReportsController@generateXls']);
	
});





