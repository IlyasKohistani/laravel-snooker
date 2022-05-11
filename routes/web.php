<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware(['guest'])->group(function () {
    Route::post('/login/auth', 'LoginController@authenticate')->name('users.authenticate');
    Route::get('/', 'LoginController@index')->name('login');
});



Route::middleware('auth')->group(function () {

    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('home/fetchWaiterTables', 'DashboardController@fetchWaiterTables')->name('dashboard.waiter');
    Route::get('home/fetchCashierTables', 'DashboardController@fetchCashierTables')->name('dashboard.cashier');


    Route::resource('/table', 'TablesController', ['except' => ['show', 'create']]);
    Route::get('/table/index/fetchData', 'TablesController@fetchData')->name('table.data');


    Route::get('/report', 'ReportController@index')->name('report.index');
    Route::post('/report', 'ReportController@indexReportData')->name('report.indexData');
    Route::get('/report/daily', 'ReportController@dailyReport')->name('report.daily');
    Route::post('/report/dailyData', 'ReportController@dailyReportData')->name('report.dailyData');
    Route::get('/report/product', 'ReportController@productReport')->name('report.product');
    Route::post('/report/productData', 'ReportController@productReportData')->name('report.productData');
    Route::get('/report/store', 'ReportController@storeReport')->name('report.store');
    Route::post('/report/storeData', 'ReportController@storeReportData')->name('report.storeData');
    Route::get('/report/staff', 'ReportController@staffReport')->name('report.staff');
    Route::post('/report/staffData', 'ReportController@staffReportData')->name('report.staffData');

    Route::resource('/category', 'CategoryController', ['except' => ['show', 'create']]);
    Route::get('/category/index/fetchData', 'CategoryController@fetchData')->name('category.data');


    Route::resource('/order', 'OrderController');
    Route::get('/order/getProductValueById/{id}', 'OrderController@getProductValueById')->name('order.productData');
    Route::get('/order/index/fetchData', 'OrderController@fetchData')->name('order.data');
    Route::post('/order/pay/{order:id}', 'OrderController@pay')->name('order.pay');
    Route::get('/order/index/printDiv/{order:id}', 'OrderController@printDiv')->name('order.print');
    Route::get('/order/index/fetchProducts/{order:id}', 'OrderController@fetchProduct')->name('order.fetchProduct');
    Route::get('/order/index/getTableProductRow', 'OrderController@getTableProductRow')->name('order.tableRowProduct');

    Route::resource('/product', 'ProductController', ['except' => ['show']]);
    Route::get('/product/fetchData', 'ProductController@fetchData')->name('product.data');
    Route::get('/product/viewproduct', 'ProductController@viewproduct')->name('product.list');

    Route::get('/company', 'CompanyController@index')->name('company');
    Route::post('/company/update', 'CompanyController@update');

    Route::resource('/users', 'UsersController');
    Route::get('/users/show/profile', 'UsersController@profile')->name('user.profile');
    Route::get('/users/show/setting', 'UsersController@setting')->name('user.setting');
    Route::post('/users/update/setting', 'UsersController@updateSetting')->name('user.updateSetting');
    Route::resource('/group', 'GroupsController', ['except' => 'show']);

    Route::resource('/store', 'StoresController', ['except' => ['show', 'create']]);
    Route::get('/store/index/fetchData', 'StoresController@fetchData')->name('store.data');


    Route::get('/auth/logout', 'LoginController@logout')->name('logout');
});
