<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\AuthManageController;
use App\Http\Controllers\DashboardManageController;
use App\Http\Controllers\ManageAccountController;
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

// Route::get('/', [AuthManageController::class, 'viewLogin'])->middleware('guest');
// Route::get('/login', [AuthManageController::class, 'viewLogin'])->name('login')->middleware('guest');
// Route::post('/verify_login', [AuthManageController::class, 'verifyLogin'])->middleware('guest');
// Route::post('/logout', [AuthManageController::class, 'logoutProcess']);

// Route::get('/dashboard', [DashboardManageController::class, 'viewDashboard'])->middleware('auth');

// Route::middleware(['auth', 'checkRole:superadmin_pabrik,superadmin_distributor'])->group(function () {
//     Route::resource('/manage_account/users', ManageAccountController::class);
//     Route::post('fetch-cities', [ManageAccountController::class, 'fetchCity']);
// });

Route::get('/', 'App\Http\Controllers\AuthManageController@viewLogin')->middleware('guest');
Route::get('/', 'App\Http\Controllers\DashboardManageController@viewDashboard')->middleware('auth');
Route::get('/login', 'App\Http\Controllers\AuthManageController@viewLogin')->name('login')->middleware('guest');
Route::post('/verify_login', 'App\Http\Controllers\AuthManageController@verifyLogin')->middleware('guest');
// Route::post('/logout', 'App\Http\Controllers\AuthManageController@logoutProcess');
Route::get('/logout', 'App\Http\Controllers\AuthManageController@logoutProcess');


// DASHBOARD
Route::middleware('auth')->group(function () {
    // MAIN
    Route::get('/dashboard', 'App\Http\Controllers\DashboardManageController@viewDashboard');
    Route::get('/dashboard/penjualan', 'App\Http\Controllers\DashboardManageController@getDateTransactionSell');
    Route::get('/dashboard/pembelian', 'App\Http\Controllers\DashboardManageController@getDateTransactionBuy');
    Route::get('/dashboard/print', 'App\Http\Controllers\DashboardManageController@print');
    Route::get('/dashboard/export/', 'App\Http\Controllers\DashboardManageController@export');

    // DETAIL
    Route::get('/dashboard/detail/{user}/{type}', 'App\Http\Controllers\DashboardManageController@viewDetailTable');
    Route::get('/dashboard/detail/print-detail/{user}/{type}', 'App\Http\Controllers\DashboardManageController@print_detail_table');
    Route::get('/dashboard/detail/export-detail/{user}/{type}', 'App\Http\Controllers\DashboardManageController@export_detail_table');
});

// KELOLA AKUN
Route::middleware('auth')->group(function () {
    Route::resource('/manage_account/users', 'App\Http\Controllers\ManageAccountController');
    Route::get('/manage_account/print/', 'App\Http\Controllers\ManageAccountController@print');
    Route::get('/manage_account/export/', 'App\Http\Controllers\ManageAccountController@export');
    Route::post('/fetch-cities', 'App\Http\Controllers\ManageAccountController@fetchCity');

    // Route::get('/manage_account/history/', 'App\Http\Controllers\ManageAccountController@history');
    Route::get('/manage_account/history/print/{id_user}', 'App\Http\Controllers\ManageAccountController@historyPrint');
    Route::get('/manage_account/history/export/{id_user}', 'App\Http\Controllers\ManageAccountController@historyExport');

    Route::get('manage_account/permission', 'App\Http\Controllers\ManageAccountController@permission');
    Route::get('/manage_account/get_permission', 'App\Http\Controllers\ManageAccountController@getPermission');
    Route::get('/manage_account/change_permission/{user}/{access}', 'App\Http\Controllers\ManageAccountController@changePermission');
    Route::get('/manage_account/access/sidebar', 'App\Http\Controllers\ManageAccountController@sidebarRefresh');

    // Route::get('/manage_account/permission/print-history-kelola-akun/', 'App\Http\Controllers\ManageAccountController@print_history_kelola_akun');
    Route::get('/manage_account/permission/print', 'App\Http\Controllers\ManageAccountController@print_permission');
    Route::get('/manage_account/permission/export', 'App\Http\Controllers\ManageAccountController@export_permission');
});

// KELOLA BARANG - DAFTAR BARANG
Route::middleware('auth')->group(function () {
    Route::get('/manage_product/print/{id}', 'App\Http\Controllers\ProductManageController@print');
    Route::get('/manage_product/export/{id}', 'App\Http\Controllers\ProductManageController@export');
    Route::get('/manage_product/printDetail/{id}', 'App\Http\Controllers\ProductManageController@printDetail');
    Route::get('/manage_product/exportDetail/{id}', 'App\Http\Controllers\ProductManageController@exportDetail');
    Route::get('/manage_product/category/export', 'App\Http\Controllers\ProductManageController@exportCategory');
    Route::post('/manage_product/category/import', 'App\Http\Controllers\ProductManageController@importCategory')->name('category.import');


    // MAIN
    Route::resource('/manage_product/products', 'App\Http\Controllers\ProductManageController');
    Route::get('/manage_product/deleteProduct/{id}', 'App\Http\Controllers\ProductManageController@deleteProduct');
    // Category
    Route::get('/manage_product/category', 'App\Http\Controllers\ProductManageController@category')->name('category.index');
    Route::get('/manage_product/category/create', 'App\Http\Controllers\ProductManageController@createCategory');
    Route::post('/manage_product/category', 'App\Http\Controllers\ProductManageController@storeCategory');
    Route::get('/manage_product/category/{category}/edit', 'App\Http\Controllers\ProductManageController@editCategory');
    Route::put('/manage_product/category/{category}', 'App\Http\Controllers\ProductManageController@updateCategory');
    Route::delete('/manage_product/category/{category}/delete', 'App\Http\Controllers\ProductManageController@destroyCategory');


    //NEW MAIN
    Route::post('/manage_product/importProduct/', 'App\Http\Controllers\ProductManageController@importProduct')->name('products.import');
    Route::get('/manage_product/exportXlsx/{id}', 'App\Http\Controllers\ProductManageController@exportXlsx');
    Route::get('/manage_product/exportDetailXlsx/{id}', 'App\Http\Controllers\ProductManageController@exportDetailXlsx');


    // SECOND
    Route::get('/manage_product/distributor/products', 'App\Http\Controllers\ProductManageController@indexSecond');
    Route::get('/manage_product/reseller/products', 'App\Http\Controllers\ProductManageController@indexSecond');
    Route::get('/manage_product/distributor/print', 'App\Http\Controllers\ProductManageController@printSecond');
    Route::get('/manage_product/reseller/print', 'App\Http\Controllers\ProductManageController@printSecond');
    Route::get('/manage_product/distributor/export', 'App\Http\Controllers\ProductManageController@exportSecond');
    Route::get('/manage_product/reseller/export', 'App\Http\Controllers\ProductManageController@exportSecond');

    //NEW
    Route::get('/manage_product/reseller/exportXlsx', 'App\Http\Controllers\ProductManageController@exportSecondXlsx');
    Route::get('/manage_product/reseller/exportXlsx/{id}', 'App\Http\Controllers\ProductManageController@exportDetailSecondXlsx');

    Route::get('/manage_product/distributor/products/{id}', 'App\Http\Controllers\ProductManageController@showSecond');
    Route::get('/manage_product/reseller/products/{id}', 'App\Http\Controllers\ProductManageController@showSecond');
    Route::get('/manage_product/distributor/products/edit/{product}', 'App\Http\Controllers\ProductManageController@editSecond');
    Route::put('/manage_product/distributor/products/update/{product}', 'App\Http\Controllers\ProductManageController@updateSecond');
    Route::get('/manage_product/distributor/print/{id}', 'App\Http\Controllers\ProductManageController@printDetailSecond');
    Route::get('/manage_product/reseller/print/{id}', 'App\Http\Controllers\ProductManageController@printDetailSecond');
    Route::get('/manage_product/distributor/export/{id}', 'App\Http\Controllers\ProductManageController@exportDetailSecond');
    Route::get('/manage_product/reseller/export/{id}', 'App\Http\Controllers\ProductManageController@exportDetailSecond');

    // THIRD
    Route::get('/manage_product/distributor_reseller/products', 'App\Http\Controllers\ProductManageController@indexThird');
    Route::get('/manage_product/distributor_reseller/products/{user}', 'App\Http\Controllers\ProductManageController@showThird');
    Route::get('/manage_product/distributor_reseller/products/chart/{user}', 'App\Http\Controllers\ProductManageController@chartThird');
    Route::get('/manage_product/distributor_reseller/products/edit/{product}', 'App\Http\Controllers\ProductManageController@editThird');
    Route::put('/manage_product/distributor_reseller/products/update/{product}', 'App\Http\Controllers\ProductManageController@updateThird');
    Route::get('/manage_product/distributor_reseller/print/', 'App\Http\Controllers\ProductManageController@printThird');
    Route::get('/manage_product/distributor_reseller/export/', 'App\Http\Controllers\ProductManageController@exportThird');
    Route::get('/manage_product/distributor_reseller/print/{idDistributor}', 'App\Http\Controllers\ProductManageController@printDetailThird');
    Route::get('/manage_product/distributor_reseller/export/{idDistributor}', 'App\Http\Controllers\ProductManageController@exportDetailThird');
    Route::get('/manage_product/distributor_reseller/chart/print/{id}', 'App\Http\Controllers\ProductManageController@printChartThird');
    Route::get('/manage_product/distributor_reseller/chart/export/{id}', 'App\Http\Controllers\ProductManageController@exportChartThird');
    // FILTER
    Route::get('/manage_product/filter/{category}/{sort}', 'App\Http\Controllers\ProductManageController@filterTable');
});

// KELOLA BARANG - INPUT PASOK
Route::middleware('auth', 'checkRole:superadmin_pabrik,admin,cashier_pabrik,accounting_pabrik')->group(function () {
    Route::resource('/manage_product/input_pasok/supplyhistories', 'App\Http\Controllers\SupplyHistoryController');
    Route::get('/manage_product/input_pasok/detail/{supply_history}', 'App\Http\Controllers\SupplyHistoryController@detail');
    Route::get('/manage_product/input_pasok/print', 'App\Http\Controllers\SupplyHistoryController@print');
    Route::get('/manage_product/input_pasok/export', 'App\Http\Controllers\SupplyHistoryController@export');
    // Route::get('/manage_product/print-detail-pasok', 'App\Http\Controllers\ProductManageController@print_detail_pasok');
    Route::get('/manage_product/input_pasok/detail/print/{supply_history}', 'App\Http\Controllers\SupplyHistoryController@printDetail');
    Route::get('/manage_product/input_pasok/detail/export/{supply_history}', 'App\Http\Controllers\SupplyHistoryController@exportDetail');
});

// KELOLA TRANSAKSI
Route::middleware('auth', 'checkRole:superadmin_distributor,cashier_distributor,accounting_distributor,reseller')->group(function () {
    //view
    Route::resource('/manage_transactions/transaction', 'App\Http\Controllers\TransactionManageController');
    Route::get('/manage_transactions/transaction_history', 'App\Http\Controllers\TransactionManageController@history');
    Route::get('/manage_transactions/transaction_sell', 'App\Http\Controllers\TransactionManageController@transactionSell');
    Route::get('/manage_transactions/transaction_history_sell', 'App\Http\Controllers\TransactionManageController@historySell');

    //transaction
    Route::get('/manage_transaction/transaction/get_list_products', 'App\Http\Controllers\TransactionManageController@getList');
    Route::get('/manage_transaction/transaction/get_stok_tersedia', 'App\Http\Controllers\TransactionManageController@getStokTersedia');
    Route::get('/manage_transaction/transaction/getDistributorName', 'App\Http\Controllers\TransactionManageController@getDistributorName');
    Route::get('/manage_transaction/transaction/check_item', 'App\Http\Controllers\TransactionManageController@checkItem');
    Route::post('/manage_transaction/transaction/order', 'App\Http\Controllers\TransactionManageController@order');
    //NEW
    Route::post('/manage_transaction/importTransaction', 'App\Http\Controllers\TransactionManageController@importTransaction')->name('transactions.import');
    Route::post('/manage_transaction/importTransactionSell', 'App\Http\Controllers\TransactionManageController@importTransactionSell')->name('transactionsSell.import');
    Route::get('/manage_transaction/buy/history/export/{id}', 'App\Http\Controllers\TransactionManageController@exportBuyHistory');
    Route::get('/manage_transaction/sell/history/export/{id}', 'App\Http\Controllers\TransactionManageController@exportSellHistory');

    Route::get('/manage_transaction/buy/history/export/', 'App\Http\Controllers\TransactionManageController@exportBuyHistory');
    Route::get('/manage_transaction/sell/history/export/', 'App\Http\Controllers\TransactionManageController@exportSellHistory');
    Route::post('/retur/to_supplier/importReturCashier', 'App\Http\Controllers\ReturCashierController@importReturCashier')->name('returCashier.import');

    //history
    // Route::get('/manage_transaction/transaction_history/get_history', 'App\Http\Controllers\TransactionManageController@getHistory');
    // Route::get('/manage_transaction/transaction_history/get_history_date', 'App\Http\Controllers\TransactionManageController@getHistoryDate');

    //sell transaction
    Route::get('/manage_transaction/transaction_sell/get_list_products_seller', 'App\Http\Controllers\TransactionManageController@getListSeller');
    Route::get('/manage_transaction/transaction_sell/getPenjualName', 'App\Http\Controllers\TransactionManageController@getPenjualName');
    Route::post('/manage_transaction/transaction_sell/sell', 'App\Http\Controllers\TransactionManageController@sell');

    //history sell
    // Route::get('/manage_transaction/transaction_history_sell/get_history_sell', 'App\Http\Controllers\TransactionManageController@getHistorySell');
    // Route::get('/manage_transaction/transaction_history_sell/get_history_sell_date', 'App\Http\Controllers\TransactionManageController@getHistorySellDate');

    //print
    // Route::get('/manage_transaction/transaction_history/print/{id}', 'App\Http\Controllers\TransactionManageController@print');
    // Route::get('/manage_transaction/transaction_history_sell/print/{id}', 'App\Http\Controllers\TransactionManageController@printSell');

    // Route::get('/manage_transaction/transaction_history/printDetail/{id}', 'App\Http\Controllers\TransactionManageController@printDetail');
    // Route::get('/manage_transaction/transaction_history_sell/printDetail/{id}', 'App\Http\Controllers\TransactionManageController@printDetailSell');

    //table for print 
    // Route::get('/manage_transaction/transaction_history/get_history_print', 'App\Http\Controllers\TransactionManageController@getHistoryPrint');
    // Route::get('/manage_transaction/transaction_history_sell/get_history_sell_print', 'App\Http\Controllers\TransactionManageController@getHistorySellPrint');

    // Route::get('/manage_transaction/transaction_history/get_history_detail_print', 'App\Http\Controllers\TransactionManageController@getHistoryDetailPrint');
    // Route::get('/manage_transaction/transaction_history_sell/get_history_sell_detail_print', 'App\Http\Controllers\TransactionManageController@getHistorySellDetailPrint');

    //load data for print
    // Route::get('/manage_transaction/transaction_history/get_history_print_data', 'App\Http\Controllers\TransactionManageController@getHistoryPrintData');
    // Route::get('/manage_transaction/transaction_history_sell/get_history_print_data', 'App\Http\Controllers\TransactionManageController@getHistorySellPrintData');

    // NEW
    Route::get('/manage_transaction/buy/history/', 'App\Http\Controllers\TransactionManageController@viewBuyHistory');
    Route::get('/manage_transaction/buy/history/get_date', 'App\Http\Controllers\TransactionManageController@getDateBuyHistory');
    Route::post('/manage_transaction/buy/history/print/', 'App\Http\Controllers\TransactionManageController@printBuyHistory');
    Route::get('/manage_transaction/buy/history/print_detail/{id_history}', 'App\Http\Controllers\TransactionManageController@printDetailBuyHistory');

    Route::get('/manage_transaction/sell/history/', 'App\Http\Controllers\TransactionManageController@viewSellHistory');
    Route::get('/manage_transaction/sell/history/get_date', 'App\Http\Controllers\TransactionManageController@getDateSellHistory');
    Route::post('/manage_transaction/sell/history/print/', 'App\Http\Controllers\TransactionManageController@printSellHistory');
    Route::get('/manage_transaction/sell/history/print_detail/{id_history}', 'App\Http\Controllers\TransactionManageController@printDetailSellHistory');
});

// NOTIFIKASI
Route::middleware('auth')->group(function () {
    Route::get('/notification', 'App\Http\Controllers\NotificationManageController@index');
    Route::get('/notification/printKlaimReward/{reward_id}', 'App\Http\Controllers\NotificationManageController@printKlaimReward');

    Route::put('/transaction/editDetail/{detail_id}', 'App\Http\Controllers\NotificationManageController@editDetailTransaction');

    Route::put('/transaction/approve/{transaction_id}', 'App\Http\Controllers\NotificationManageController@approveTransaction');
    Route::get('/retur/penjualan/approve/{retur_id}', 'App\Http\Controllers\NotificationManageController@approveReturPenjualan');
    Route::get('/retur/pembelian/approve/{retur_id}', 'App\Http\Controllers\NotificationManageController@approveReturPembelian');

    Route::get('/transaction/print/{transaction_id}', 'App\Http\Controllers\NotificationManageController@printTransaction');
    Route::get('/retur/penjualan/print/{retur_id}', 'App\Http\Controllers\NotificationManageController@printReturPenjualan');
    Route::get('/retur/pembelian/print/{retur_id}', 'App\Http\Controllers\NotificationManageController@printReturPembelian');

    Route::get('/claim_reward/approve/{reward_history_id}', 'App\Http\Controllers\NotificationManageController@approveClaimReward');
    Route::get('/terima_stok/approve/{id_terimaStok}', 'App\Http\Controllers\NotificationManageController@approveTerimaStok');

    Route::post('/notification/claim_reward/{id}', 'App\Http\Controllers\NotificationManageController@claimReward');
});

// TRACKING SALES
// Route::middleware('auth')->group(function(){
//     Route::get('/tracking_sales', 'App\Http\Controllers\TrackingSalesManageController@index');
//     Route::get('/tracking_sales/new', 'App\Http\Controllers\TrackingSalesManageController@create');
//     Route::get('/tracking_sales/show/{id}', 'App\Http\Controllers\TrackingSalesManageController@show');
//     Route::post('/tracking_sales/store', 'App\Http\Controllers\TrackingSalesManageController@store');
//     Route::get('/tracking_sales/{id}', 'App\Http\Controllers\TrackingSalesManageController@showSecond');
//     Route::get('/tracking_sales/print_detail/{id}', 'App\Http\Controllers\TrackingSalesManageController@printDetail');
//     Route::get('/tracking_sales/export_detail/{id}', 'App\Http\Controllers\TrackingSalesManageController@exportDetail');
//     Route::get('/tracking_sales/print/{id}', 'App\Http\Controllers\TrackingSalesManageController@print');
//     Route::get('/tracking_sales/export/{id}', 'App\Http\Controllers\TrackingSalesManageController@export');
// });

// MANAGE REPORT - TRANSACTION
Route::middleware('auth')->group(function () {
    // SELL
    Route::get('/manage_report/transaction/sell', 'App\Http\Controllers\ManageReport@indexTransactionSell');
    // Route::get('/manage_report/transactions/sell/get_history', 'App\Http\Controllers\ManageReport@getHistorySell');
    Route::get('/manage_report/transaction/sell/get_date', 'App\Http\Controllers\ManageReport@getDateTransactionSell');
    Route::post('/manage_report/transaction/sell/print', 'App\Http\Controllers\ManageReport@printTransactionSell');
    Route::get('/manage_report/transaction/sell/print_detail/{id}/{type}', 'App\Http\Controllers\ManageReport@printDetailTransactionSell');

    // BUY
    Route::get('/manage_report/transaction/buy', 'App\Http\Controllers\ManageReport@indexTransactionBuy');
    Route::get('/manage_report/transaction/buy/get_date', 'App\Http\Controllers\ManageReport@getDateTransactionBuy');
    // Route::get('/manage_report/transactions/buy/get_history_date', 'App\Http\Controllers\ManageReport@getHistoryBuyDate');
    Route::post('/manage_report/transaction/buy/print', 'App\Http\Controllers\ManageReport@printTransactionBuy');
    Route::get('/manage_report/transaction/buy/print_detail/{id}/{type}', 'App\Http\Controllers\ManageReport@printDetailTransactionBuy');
});

// MANAGE REPORT - RETUR
Route::middleware('auth')->group(function () {
    // BUY
    Route::get('/manage_report/transaction/retur/buy', 'App\Http\Controllers\ManageReport@indexTransactionReturBuy');
    // Route::get('/manage_report/transactions/buy/get_history', 'App\Http\Controllers\ManageReport@getHistoryBuy');
    Route::get('/manage_report/transaction/retur/buy/get_date', 'App\Http\Controllers\ManageReport@indexTransactionReturBuy');
    // Route::post('/manage_report/transaction/retur/buy/print', 'App\Http\Controllers\ManageReport@printTransactionReturBuy');
    // Route::get('/manage_report/transaction/retur/buy/print_detail/{id}/{type}', 'App\Http\Controllers\ManageReport@printDetailTransactionReturBuy');

    // SELL
    Route::get('/manage_report/transaction/retur/sell', 'App\Http\Controllers\ManageReport@indexTransactionReturSell');
    // Route::get('/manage_report/transactions/sell/get_history', 'App\Http\Controllers\ManageReport@getHistorySell');
    Route::get('/manage_report/transaction/retur/sell/get_date', 'App\Http\Controllers\ManageReport@indexTransactionReturSell');
    // Route::post('/manage_report/transaction/retur/sell/print', 'App\Http\Controllers\ManageReport@printTransactionReturSell');
    // Route::get('/manage_report/transaction/retur/sell/print_detail/{id}/{type}', 'App\Http\Controllers\ManageReport@printDetailTransactionReturSell');
});

// MANAGE REPORT - PEGAWAI
// Route::middleware('auth', 'checkRole:superadmin_pabrik,superadmin_distributor')->group(function(){
Route::middleware('auth')->group(function () {
    Route::get('/manage_report/users', 'App\Http\Controllers\ManageReport@indexUser');
    Route::get('/manage_report/users/getDate', 'App\Http\Controllers\ManageReport@getDateRetur');
    Route::get('/manage_report/users/print', 'App\Http\Controllers\ManageReport@printUser');
    Route::get('/manage_report/users/export', 'App\Http\Controllers\ManageReport@exportUser');
    Route::get('/manage_report/users/detail/{id}', 'App\Http\Controllers\ManageReport@detailUser');
    Route::get('/manage_report/users/detail/print/{id}', 'App\Http\Controllers\ManageReport@printDetailUser');
    Route::get('/manage_report/users/detail/export/{id}', 'App\Http\Controllers\ManageReport@exportDetailUser');
    Route::get('/manage_report/users/get_pembelian/', 'App\Http\Controllers\ManageReport@getPembelianUser');
    Route::get('/manage_report/users/get_penjualan/', 'App\Http\Controllers\ManageReport@getPenjualanUser');

    // Retur Report
    Route::get('/manage_report/returs/getDate', 'App\Http\Controllers\ManageReport@getDateRetur');
    Route::get('/manage_report/returs/transaksi/getDate', 'App\Http\Controllers\ManageReport@getDateReturTransaksi');

    // Product Report
    Route::get('/manage_report/products/getDate', 'App\Http\Controllers\ManageReport@getDateProduk');

    // Akun Report
    Route::get('/manage_report/akuns/getDate', 'App\Http\Controllers\ManageReport@getDateAkun');
});

// RETUR
Route::middleware('auth')->group(function () {
    Route::get('/retur/to_supplier/', 'App\Http\Controllers\ReturController@indexReturSupplier');
    Route::get('/retur/to_supplier/create/', 'App\Http\Controllers\ReturController@createReturSupplier');
    Route::get('/retur/to_supplier/getDetails/{id}', 'App\Http\Controllers\ReturController@getDetails');
    Route::post('/retur/to_supplier/store/', 'App\Http\Controllers\ReturController@storeReturSupplier');
    Route::get('/retur/to_supplier/print/', 'App\Http\Controllers\ReturController@printReturSupplier');
    Route::get('/retur/to_supplier/export/', 'App\Http\Controllers\ReturController@exportReturSupplier');
    Route::get('/retur/to_supplier/detail/{id}', 'App\Http\Controllers\ReturController@detailReturSupplier');
    Route::get('/retur/to_supplier/printDetail/{id}', 'App\Http\Controllers\ReturController@printDetailReturSupplier');
    Route::get('/retur/to_supplier/exportDetail/{id}', 'App\Http\Controllers\ReturController@exportDetailReturSupplier');

    //import Retur
    Route::post('/retur/to_supplier/importRetur', 'App\Http\Controllers\ReturController@importRetur')->name('retur.import');
    Route::post('/retur/to_supplier/importReturCashier', 'App\Http\Controllers\ReturController@importReturCashier')->name('returCashier.import');

    //export
    Route::get('/retur/to_supplier/exportXlsx/{id}', 'App\Http\Controllers\ReturController@exportReturSupplierXlsx');

    // Retur Cashier
    Route::get('/retur/to_cashier/', 'App\Http\Controllers\ReturCashierController@indexReturCashier');
    Route::get('/retur/to_cashier/create/', 'App\Http\Controllers\ReturCashierController@createReturCashier');
    Route::get('/retur/to_cashier/getDetails/{id}', 'App\Http\Controllers\ReturCashierController@getDetails')->name('retur.cashier.get_details');
    Route::post('/retur/to_cashier/store/', 'App\Http\Controllers\ReturCashierController@storeReturCashier');
    Route::get('/retur/to_cashier/print/', 'App\Http\Controllers\ReturCashierController@printReturCashier');
    Route::get('/retur/to_cashier/export/', 'App\Http\Controllers\ReturCashierController@exportReturCashier');
    Route::get('/retur/to_cashier/detail/{id}', 'App\Http\Controllers\ReturCashierController@detailReturCashier');
    Route::get('/retur/to_cashier/printDetail/{id}', 'App\Http\Controllers\ReturCashierController@printDetailReturCashier');
    Route::get('/retur/to_cashier/exportDetail/{id}', 'App\Http\Controllers\ReturCashierController@exportDetailReturCashier');

    //NEW
    Route::get('/retur/to_cashier/exportXlsx/{id}', 'App\Http\Controllers\ReturCashierController@exportReturXlsx');
});

// LOST PRODUCT
Route::middleware('auth', 'checkRole:superadmin_pabrik,superadmin_distributor,reseller')->group(function () {
    Route::resource('/report_product/lostproducts/', 'App\Http\Controllers\LostProductController');
    Route::get('/report_product/lostproducts/print', 'App\Http\Controllers\LostProductController@print');
    Route::get('/report_product/lostproducts/export', 'App\Http\Controllers\LostProductController@export');
    Route::get('/report_product/lostproducts/printDetail/{id}', 'App\Http\Controllers\LostProductController@printDetail');
});

// CRM
Route::middleware('auth')->group(function () {
    // MAIN
    Route::get('/crm/omzet/{id}', 'App\Http\Controllers\CRMController@viewOmzet');
    Route::get('/crm/omzet/print/{id}', 'App\Http\Controllers\CRMController@print_omzet');
    Route::get('/crm/omzet/export/{id}', 'App\Http\Controllers\CRMController@export_omzet');
    Route::get('/crm/omzet/history/{id}', 'App\Http\Controllers\CRMController@viewOmzetHistory');
    Route::get('/crm/print-history/{id}', 'App\Http\Controllers\CRMController@print_history');
    Route::get('/crm/export-history/{id}', 'App\Http\Controllers\CRMController@export_history');

    Route::post('/crm/omzet/claim_reward/{id}', 'App\Http\Controllers\CRMController@claimReward');
    Route::get('/crm/omzet/get_reward/{id}', 'App\Http\Controllers\CRMController@getReward');

    // SECOND
    Route::get('/crm/list/', 'App\Http\Controllers\CRMController@viewListSecond');
    Route::get('/crm/list/print', 'App\Http\Controllers\CRMController@print_list');
    Route::get('/crm/list/export', 'App\Http\Controllers\CRMController@export_list');

    // THIRD
    Route::get('/crm/list_distributor/', 'App\Http\Controllers\CRMController@viewListDistThird');
    Route::get('/crm/list_distributor/print', 'App\Http\Controllers\CRMController@printListDistThird');
    Route::get('/crm/list_distributor/export', 'App\Http\Controllers\CRMController@exportListDistThird');

    Route::get('/crm/list_reseller/{id}', 'App\Http\Controllers\CRMController@viewListResThird');
    Route::get('/crm/list_reseller/print/{id}', 'App\Http\Controllers\CRMController@printListResThird');
    Route::get('/crm/list_reseller/export/{id}', 'App\Http\Controllers\CRMController@exportListResThird');

    // RESET
    Route::get('/crm/reset_poin/{type}', 'App\Http\Controllers\CRMController@resetPoin');
});

Route::middleware('auth')->group(function () {
    // REWARD
    Route::get('/crm/reward/', 'App\Http\Controllers\CRMController@viewReward');
    Route::get('/crm/reward/create/{type}', 'App\Http\Controllers\CRMController@createReward');
    Route::post('/crm/reward/store/{type}', 'App\Http\Controllers\CRMController@storeReward');
    Route::get('/crm/reward/edit/{id}', 'App\Http\Controllers\CRMController@editReward');
    Route::post('/crm/reward/update', 'App\Http\Controllers\CRMController@updateReward');
    Route::get('/crm/reward/print-reward', 'App\Http\Controllers\CRMController@print_reward');
    Route::get('/crm/reward/export-reward', 'App\Http\Controllers\CRMController@export_reward');

    // CLUSTER
    Route::get('/crm/cluster/', 'App\Http\Controllers\CRMController@viewCluster');
    Route::get('/crm/cluster/edit', 'App\Http\Controllers\CRMController@editCluster');
    Route::get('/crm/cluster/print-cluster', 'App\Http\Controllers\CRMController@print_cluster');


    // POIN
    Route::get('/crm/poin/', 'App\Http\Controllers\CRMController@viewPoin');
    Route::get('/crm/poin/edit/{id}', 'App\Http\Controllers\CRMController@editPoin');
    Route::post('/crm/poin/update', 'App\Http\Controllers\CRMController@updatePoin');
    Route::get('/crm/poin/print-poin', 'App\Http\Controllers\CRMController@print_point');
    Route::get('/crm/poin/export-poin', 'App\Http\Controllers\CRMController@export_point');
});

// MANAGE SALES
Route::middleware('auth')->group(function () {
    Route::get('/sales/list_distributor/', 'App\Http\Controllers\ManageSalesController@viewSalesListDistributor');
    Route::get('/sales/list_distributor/print', 'App\Http\Controllers\ManageSalesController@printSalesListDistributor');
    Route::get('/sales/list_distributor/export', 'App\Http\Controllers\ManageSalesController@exportSalesListDistributor');

    Route::get('/sales/index/{id_group}/', 'App\Http\Controllers\ManageSalesController@viewSales');
    Route::get('/sales/print/{id_group}', 'App\Http\Controllers\ManageSalesController@printSales');
    Route::get('/sales/export/{id_group}', 'App\Http\Controllers\ManageSalesController@exportSales');

    Route::get('/sales/setting_bonus/{id_group}/', 'App\Http\Controllers\ManageSalesController@viewSettingBonus');
    Route::get('/sales/setting_bonus/edit/{id_bonus}/', 'App\Http\Controllers\ManageSalesController@editSettingBonus');
    Route::post('/sales/setting_bonus/update', 'App\Http\Controllers\ManageSalesController@updateSettingBonus');

    // TRACKING
    Route::get('/sales/tracking/{id_sales}', 'App\Http\Controllers\ManageSalesController@viewTrackingHistory');
    Route::get('/sales/new_tracking/', 'App\Http\Controllers\ManageSalesController@createTrackingHistory');
    Route::post('/sales/store_tracking', 'App\Http\Controllers\ManageSalesController@storeTrackingHistory');
    Route::get('/sales/detail_tracking/{id_tracking}', 'App\Http\Controllers\ManageSalesController@viewDetailTrackingHistory');
    Route::get('/sales/tracking/print/{id_sales}', 'App\Http\Controllers\ManageSalesController@printTrackingHistory');
    Route::get('/sales/tracking/export/{id_sales}', 'App\Http\Controllers\ManageSalesController@exportTrackingHistory');
    Route::get('/sales/detail_tracking/print/{id_tracking}', 'App\Http\Controllers\ManageSalesController@printDetailTrackingHistory');
    Route::get('/sales/detail_tracking/export/{id_tracking}', 'App\Http\Controllers\ManageSalesController@exportDetailTrackingHistory');

    // PRODUCT
    Route::get('/sales/product/{id_sales}', 'App\Http\Controllers\ManageSalesController@viewProduct');
    Route::get('/sales/product/edit/{id_product}', 'App\Http\Controllers\ManageSalesController@editProduct');
    Route::post('/sales/product/update', 'App\Http\Controllers\ManageSalesController@updateProduct');
    Route::get('/sales/product/create/stok/{id_sales}', 'App\Http\Controllers\ManageSalesController@createStokProduct');
    Route::get('/sales/product/create/check_item', 'App\Http\Controllers\ManageSalesController@checkStokProduct');
    Route::get('/sales/product/create/get_list_products_sales', 'App\Http\Controllers\ManageSalesController@getListSalesProduct');
    Route::post('/sales/product/store/stok/', 'App\Http\Controllers\ManageSalesController@storeStokProduct');
    Route::get('/sales/product/print/{id_sales}', 'App\Http\Controllers\ManageSalesController@printProduct');
    Route::get('/sales/product/export/{id_sales}', 'App\Http\Controllers\ManageSalesController@exportProduct');


    // HISTORY BONUS
    Route::get('/sales/history/{id_sales}', 'App\Http\Controllers\ManageSalesController@viewHistory');

    // Route::get('/sales/print-detail', 'App\Http\Controllers\ManageSalesController@print_detail');
    Route::get('/sales/print-history-bonus/{id_sales}', 'App\Http\Controllers\ManageSalesController@printHistoryBonus');
    Route::get('/sales/export-history-bonus/{id_sales}', 'App\Http\Controllers\ManageSalesController@exportHistoryBonus');

    // HISTORY PRODUCT
    Route::get('/sales/history-items/{id_item}', 'App\Http\Controllers\ManageSalesController@viewSalesHistoryItems');
    Route::get('/sales/print-history-items/{id_item}', 'App\Http\Controllers\ManageSalesController@printSalesHistoryItems');
    Route::get('/sales/export-history-items/{id_item}', 'App\Http\Controllers\ManageSalesController@exportSalesHistoryItems');
    Route::get('/sales/get_history', 'App\Http\Controllers\ManageSalesController@getHistory');
    Route::get('/sales/get_history_date', 'App\Http\Controllers\ManageSalesController@getHistoryDate');
});

// UI
Route::middleware('auth', 'checkRole:superadmin_pabrik,superadmin_distributor,reseller')->group(function () {
    Route::get('/ui/sales/', 'App\Http\Controllers\UIController@viewSales');
    Route::get('/ui/sales/create/', 'App\Http\Controllers\UIController@viewAddSales');
    Route::get('/ui/sales/setting/', 'App\Http\Controllers\UIController@viewSettingSales');
    Route::get('/ui/sales/detail/', 'App\Http\Controllers\UIController@viewDetailSales');
    Route::get('/ui/sales/detail/add/', 'App\Http\Controllers\UIController@viewAddDetailSales');
    Route::get('/ui/historyBonus/', 'App\Http\Controllers\UIController@viewHistoryBonus');
});


// Cash Opname
Route::middleware('auth', 'checkRole:superadmin_pabrik,superadmin_distributor,reseller')->group(function () {
    Route::get('/cash_opname/report', 'App\Http\Controllers\CashOpnameController@report')->name('cash_opname.report');
    Route::get('/cash_opname/open', 'App\Http\Controllers\CashOpnameController@open')->name('cash_opname.open');
    Route::post('/cash_opname', 'App\Http\Controllers\CashOpnameController@storeOpen')->name('cash_opname.store_open');
    Route::get('/cash_opname/close', 'App\Http\Controllers\CashOpnameController@close')->name('cash_opname.close');
    Route::post('/cash_opname/close/store', 'App\Http\Controllers\CashOpnameController@storeClose')->name('cash_opname.store_close');
});
