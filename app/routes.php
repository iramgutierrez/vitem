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

Route::get('POS/{method?}' , [/*'before' => 'oauth' , */ 'as' => 'POS', 'uses' => 'POSController@API']);

Route::post('POS/{method?}' , ['as' => 'POSPost', 'uses' => 'POSController@APIPost']);

Route::post('oauth/access_token' , function() {

    return Response::json(Authorizer::issueAccessToken());

});

Route::group(['before' => 'guest'], function () {

	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
	Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

	Route::get('API/products/findRemote/{find?}' , ['as' => 'productsAPI', 'uses' => 'ProductsController@findRemote']);

});

Route::group(['before' => 'auth'], function () {

	Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@dashboard']);

	Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

	Route::resource('stores', 'StoresController');

	Route::get('change_store/{id?}', ['as' => 'stores.change', 'uses' => 'StoresController@change']);

	Route::resource('users', 'UsersController');

	Route::resource('roles', 'RolesController');

	Route::resource('clients', 'ClientsController');

	Route::post('clients/image_ajax' , ['as' => 'clients.image_ajax', 'uses' => 'ClientsController@image_ajax']);

	Route::resource('suppliers', 'SuppliersController');

	Route::resource('products', 'ProductsController');

	Route::post('products/image_ajax' , ['as' => 'products.image_ajax', 'uses' => 'ProductsController@image_ajax']);

	Route::resource('packs', 'PacksController');

	Route::resource('sales', 'SalesController');

	Route::resource('sale_payments', 'SalePaymentsController');

	Route::get('sale_payments/create/{sale_id}' , ['as' => 'sale_payments.create.sale_id', 'uses' => 'SalePaymentsController@create']);

	Route::get('commissions/create/{sale_id}/{employee_id?}' , ['as' => 'commissions.create.sale_id', 'uses' => 'CommissionsController@create']);

	Route::get("commissions/create-many" , ['as' => 'commissions.create_many_get', 'uses' => 'CommissionsController@createManyGet']);

	Route::post('commissions/create-many' , ['as' => 'commissions.create_many', 'uses' => 'CommissionsController@createMany']);

	Route::resource('commissions', 'CommissionsController');

	Route::resource('destinations', 'DestinationsController');

	Route::resource('deliveries', 'DeliveriesController');

	Route::get('deliveries/create/{sale_id}' , ['as' => 'deliveries.create.sale_id', 'uses' => 'DeliveriesController@create']);

	Route::resource('expenses', 'ExpensesController');

	Route::resource('settings', 'SettingsController');

	Route::resource('orders', 'OrdersController');

	Route::get('orders/create/{supplier_id?}/{product_id?}' , ['as' => 'orders.create.supplier_id', 'uses' => 'OrdersController@create']);

	Route::resource('devolutions', 'DevolutionsController');

	Route::resource('pay_types', 'PayTypesController');

	Route::resource('expense_types', 'ExpenseTypesController');

	Route::resource('colors', 'ColorsController');

	Route::resource('client_types', 'ClientTypesController');

	Route::get('addresses/create/{entity}/{entity_id}' , ['as' => 'addresses.create.entity.entity_id', 'uses' => 'AddressesController@create']);

	Route::get('API/lists/{method}' , ['as' => 'usersAPI', 'uses' => 'HomeController@API']);

	Route::get('API/users' , ['as' => 'usersAPI', 'uses' => 'UsersController@API']);

	Route::get('API/users/{method}' , ['as' => 'usersAPI', 'uses' => 'UsersController@API']);

	Route::get('API/roles' , ['as' => 'rolesAPI', 'uses' => 'RolesController@API']);

	Route::get('API/roles/{method}' , ['as' => 'rolesAPI', 'uses' => 'RolesController@API']);

	Route::get('API/entities' , ['as' => 'entitiesAPI', 'uses' => 'EntitiesController@API']);

	Route::get('API/entities/{method}' , ['as' => 'entitiesAPI', 'uses' => 'EntitiesController@API']);

	Route::get('API/actions' , ['as' => 'actionsAPI', 'uses' => 'ActionsController@API']);

	Route::get('API/actions/{method}' , ['as' => 'actionsAPI', 'uses' => 'ActionsController@API']);

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

	Route::get('API/movements/' , ['as' => 'movementsAPI', 'uses' => 'MovementsController@API']);

	Route::get('API/movements/{method}' , ['as' => 'movementsAPI', 'uses' => 'MovementsController@API']);

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

	Route::get('API/permissions/{method?}' , ['as' => 'permissionsAPI', 'uses' => 'PermissionsController@API']);

	Route::get('API/pay_types/{method?}' , ['as' => 'payTypesAPI', 'uses' => 'PayTypesController@API']);

	Route::get('API/expense_types/{method?}' , ['as' => 'expenseTypesAPI', 'uses' => 'ExpenseTypesController@API']);

	Route::get('API/colors/{method?}' , ['as' => 'colorsAPI', 'uses' => 'ColorsController@API']);

	Route::get('API/client_types/{method?}' , ['as' => 'clientTypesAPI', 'uses' => 'ClientTypesController@API']);

	Route::get('API/orders/{method?}' , ['as' => 'ordersAPI', 'uses' => 'OrdersController@API']);

	Route::get('API/devolutions/{method?}' , ['as' => 'devolutionsAPI', 'uses' => 'DevolutionsController@API']);

	Route::get('API/stores/{method?}' , ['as' => 'storesAPI', 'uses' => 'StoresController@API']);



	Route::get('reports/sales' , ['as' => 'reports.sales', 'uses' => 'ReportsController@sales']);

	Route::get('reports/movements' , ['as' => 'reports.movements', 'uses' => 'ReportsController@movements']);

	Route::get('reports/compare-sellers' , ['as' => 'reports.compare_sellers', 'uses' => 'ReportsController@compare_sellers']);

	Route::get('reports/compare-drivers' , ['as' => 'reports.compare_drivers', 'uses' => 'ReportsController@compare_drivers']);

	Route::post('reports/generate_xls' , ['as' => 'reports.generate_xls', 'uses' => 'ReportsController@generateXls']);

	Route::post('reports/generate_custom_xls' , ['as' => 'reports.generate_custom_xls', 'uses' => 'ReportsController@generateCustomXls']);

});





