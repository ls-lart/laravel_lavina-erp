<?php

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

Route::get('/', function () {
    return redirect('/login');
});

//Route::auth();

// Admin middleware
Route::group(['middleware'=>'admin', 'as' => 'admin.'], function(){

	Route::get('/admin', function(){
		return view('admin.index');
	});
	Route::resource('/admin/users', 'AdminUsersController');
	//Route::get('admin/media/upload',['as'=>'admin.media.upload', 'uses'=>'AdminMediasController@store']);
	
});

// Business Owner middleware
Route::group(['middleware'=>'bowner', 'as' => 'bowner.'], function(){

	// Homepage
	Route::get('/bowner', function(){
		return view('bowner.index');
	});

	// Human Resource route
	Route::resource('/bowner/humans', 'BownerHumansController');

	Route::get('/bowner/humans/attendance/tool',[
		'uses' => 'BownerHumansController@attendanceTool',
		'as' => 'humans.attendance.tool',
	]);

	Route::post('/bowner/humans/attendance/tool/store',[
		'uses' => 'BownerHumansController@storeAttendance',
		'as' => 'humans.attendance.store',
	]);

	


	// Salary route
	Route::post('/bowner/salaries', 'BownerSalariesController@index');
	Route::post('/bowner/salaries/store', [
		'uses' => 'BownerSalariesController@store',
		'as' => 'salaries.store' ]);
	Route::resource('/bowner/salaries', 'BownerSalariesController', ['except'=>['store']]);

	// Leave route
	Route::resource('/bowner/leaves', 'LeavesController');

	// Chart route
	Route::get('bowner/chart', [
		'uses' => 'ChartController@index',
		'as' =>'chart.index'
	]);

	// Customer route
	Route::resource('bowner/customer', 'CustomerController', ['except'=>['store']]);

	// Order route
	Route::get('order_delete/{order_id}',[
		'uses' => 'OrderController@destroy',
		'as' => 'orders.destroy',
	]);
	Route::get('order_complete/{order_id}',[
		'uses' => 'OrderController@complete',
		'as' =>'orders.complete',
	]);
	Route::get('order_submit/{order_id}', [
		'uses' => 'OrderController@submit',
		'as' => 'orders.submit',
	]);
	Route::get('order_deliver/{order_id}', [
		'uses' => 'OrderController@deliver',
		'as' => 'orders.deliver',
	]);

	
	Route::get('bowner/inventories/material/purchase', [
		'uses' => 'MaterialPurchaseController@index',
		'as' => 'purchase.index'
	]);
	Route::get('bowner/inventories/material/purchase/create', [
		'uses' => 'MaterialPurchaseController@create',
		'as' => 'purchase.create'
	]);
	Route::post('bowner/inventories/material/purchase/store', [
		'uses' => 'MaterialPurchaseController@store',
		'as' => 'purchase.store'
	]);





	Route::get('bowner/inventories/products/purchase/request/{product_id}', [
		'uses' => 'SupplierController@requestProductPurchase',
		'as' => 'product.purchase.request'
	]);
	Route::post('bowner/inventories/products/purchase/store/', [
		'uses' => 'SupplierController@storeProductPurchase',
		'as' => 'product.purchase.store'
	]);

	
	
});

// Order route

Route::group(['middleware'=>'auth'], function(){

	Route::resource('/orders', 'OrderController', ['except'=>['destroy']]);
	Route::get('/delete_order/{order_id}',[
		'uses' => 'OrderController@destroy',
		'as' => 'orders.destroy',
	]);
	Route::get('/complete_order/{order_id}',[
		'uses' => 'OrderController@complete',
		'as' =>'orders.complete',
	]);
	Route::get('order_deliver/submit/{order_id}', [
		'uses' => 'OrderController@ReadyToDeliver',
		'as' => 'orders.deliver',
	]);
	Route::get('order_deliver/{order_id}', [
		'uses' => 'OrderController@deliver',
		'as' => 'orders.delivery',
	]);
	Route::get('order_deliver/partial/{order_id}', [
		'uses' => 'OrderController@partialDeliver',
		'as' => 'orders.partial.delivery',
	]);
	Route::post('order_deliver/partial/delivery/{order_id}', [
		'uses' => 'OrderController@partialDelivery',
		'as' => 'orders.partial.deliver',
	]);




	Route::get('accounting', [
		'uses' => 'AccountingController@index',
		'as' => 'accounting.index',
	]);
	// accounting  

	Route::get('accounting/payment/create',[
		'uses' => 'AccountingController@createPayment',
		'as' => 'accounting.payment.create'

	]);
	Route::get('accounting/payment/store',[
		'uses' => 'AccountingController@storePayment',
		'as' => 'accounting.payment.store'

	]);

// BusinessOwner_Manager middleware
// Production route
	Route::resource('bowner/production', 'ProductionController');

	Route::get('bowner/complete_production/{o_qty}/{p_id}/{p_qty}',[
		'uses' => 'ProductionController@complete',
		'as' =>'production.complete',
	]);

	Route::get('bowner/production/bom/new',[
		'uses' => 'ProductionController@BOM',
		'as' => 'production.bom.index'

	]);

	Route::post('production/bom/save',[
		'uses' => 'ProductionController@SaveBOM',
		'as' => 'production.bom.save'

	]);
	Route::get('production/bom/details/{bom_id}',[
		'uses' => 'ProductionController@BOMDetails',
		'as' => 'production.bom.details'

	]);
	Route::get('production/shift_report/show',[
		'uses' => 'ProductionController@showReports',
		'as' => 'production.shift.show'

	]);

	Route::get('production/shift_report/show/manafacturing',[
		'uses' => 'ProductionController@showShiftReportManfacturing',
		'as' => 'production.shift.show.manafacturing'

	]);

	Route::get('production/shift_report/show/packaging',[
		'uses' => 'ProductionController@showShiftReportPackaging',
		'as' => 'production.shift.show.packaging'

	]);

	Route::post('production/shift_report/store}',[
		'uses' => 'ProductionController@storeShiftReport',
		'as' => 'production.shift.store'

	]);
	Route::post('production/shift_report/store/pack}',[
		'uses' => 'ProductionController@storeShiftReportPackaging',
		'as' => 'production.shift.store.pack'

	]);


	


});


	
Route::group(['middleware' => 'bowner_manager', 'as' => 'bowner.'], function() {

	Route::get('manager', function(){
		return view('bowner.index');
	});

	
	

	// Inventories route
	Route::resource('bowner/inventories', 'InventoryController');

	Route::get('bowner/inventories/product/edit/{product_id}', [
		'uses' => 'InventoryController@editProduct',
		'as' => 'inventories.product.edit'
	]);

	Route::get('bowner/inventories/product/create', [
		'uses' => 'InventoryController@createProduct',
		'as' => 'inventories.product.create'
	]);

	Route::post('bowner/inventories/product/store', [
		'uses' => 'InventoryController@storeProduct',
		'as' => 'inventories.product.store'
	]);

	Route::get('bowner/inventories/material/create', [
		'uses' => 'InventoryController@createMaterial',
		'as' => 'inventories.material.create'
	]);
	
	Route::post('bowner/inventories/material/store', [
		'uses' => 'InventoryController@storeMaterial',
		'as' => 'inventories.material.store'
	]);

	Route::get('bowner/inventories/material/edit/{material_id}', [
		'uses' => 'InventoryController@editMaterial',
		'as' => 'inventories.material.edit'
	]);
	Route::patch('bowner/inventories/product/update/{product_id}', [
		'uses' => 'InventoryController@updateProduct',
		'as' => 'inventories.product.update'
	]);
	Route::patch('bowner/inventories/material/update/{material_id}', [
		'uses' => 'InventoryController@updateMaterial',
		'as' => 'inventories.material.update'
	]);

	// Purchasing route
	Route::resource('bowner/inventories/material/purchase', 'MaterialPurchaseController', ['except'=>'destroy']);
	Route::get('bowner/inventories/material/purchase/delete/{purchase_id}', [
		'uses' => 'MaterialPurchaseController@destroy',
		'as' => 'purchase.destroy'
	]);
	Route::get('bowner/inventories/purchase/complete/{purchase_id}', [
		'uses' => 'SupplierController@complete',
		'as' => 'purchase.complete'
	]);

	Route::get('bowner/inventories/purchase/confirm/{purchase_id}', [
		'uses' => 'SupplierController@recievingConfirmation',
		'as' => 'purchase.receiving.confirm'
	]);

	Route::post('bowner/inventories/purchase/receive/{purchase_id}', [
		'uses' => 'SupplierController@recievingComplete',
		'as' => 'purchase.receiving.complete'
	]);

	// Supplier route
	Route::resource('bowner/supplier', 'SupplierController');

	

	


});





// Employee_BusinessOwner middleware
Route::group(['middleware' => 'bowner_employee'], function() {

	// Order route
	Route::resource('orders', 'OrderController', ['except'=>['destroy']]);

	// Customer creation route
	Route::get('customer/create', 'CustomerController@create');
	Route::post('customer', 'CustomerController@store')->name('customer');

	

});

Auth::routes();

Route::get('/home', 'HomeController@index');
