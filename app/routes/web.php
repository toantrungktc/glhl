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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }else{
        return view('auth.login');
    }
});



//Auth::routes();

Auth::routes(['register' => false]);


Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index')
        ->name('list_user');
    Route::get('/trash', 'UserController@trash')
        ->name('trash_user');
    
    Route::get('/show/{user}', 'UserController@show')
        ->name('show_user');
    Route::get('/profile', 'UserController@profile')
        ->name('profile_user');
    Route::post('/profile2', 'UserController@profileSave')
        ->name('profilesave_user');
    Route::get('/create', 'UserController@create')
        ->name('create_user');
    Route::post('/create', 'UserController@store')
        ->name('store_user');
    Route::get('/edit/{user}', 'UserController@edit')
        ->name('edit_user');
    Route::post('/update/{user}', 'UserController@update')
        ->name('update_user');
    Route::get('/delete/{user}', 'UserController@delete')
        ->name('delete_user');
    Route::get('/restore/{user}', 'UserController@restore')
        ->name('restore_user');
    Route::get('/forcedelete/{user}', 'UserController@forcedelete')
        ->name('forcedelete_user');
    Route::get('/test', 'UserController@test')
        ->name('test_user');
    Route::get('/test2', 'UserController@getStudents')
        ->name('list_user3');
    Route::get('/search', 'UserController@search')
        ->name('user_search');
    Route::get('/list', 'UserController@getUsers')
        ->name('list_user2');
    Route::get('/trash2', 'UserController@getTrashUsers')
        ->name('trash2_user');
        
    Route::post('/update_file', 'UserController@update_avatar')
        ->name('update_avatar');

    Route::post('/crop', 'UserController@crop_avatar')
        ->name('crop_avatar');
    Route::post('/changepassword', 'UserController@changePassword')
        ->name('change_password');
    Route::post('/updateinfo', 'UserController@update_info')
        ->name('update_info');

    
    Route::get('/role', 'UserController@role')
        ->name('list_role');
    Route::get('/role/create', 'UserController@role_create')
        ->name('create_role');
    Route::post('/role/create', 'UserController@role_store')
        ->name('store_role');
    Route::get('/role/show/{role}', 'UserController@role_show')
        ->name('show_role');
    Route::get('/role/edit/{role}', 'UserController@role_edit')
        ->name('edit_role');
    Route::post('/role/update/{role}', 'UserController@role_update')
        ->name('update_role');
    Route::get('/role/delete/{role}', 'UserController@role_delete')
        ->name('delete_role');
    Route::get('/role/list', 'UserController@getRoles')
        ->name('list2_role');
    Route::get('/permission', 'UserController@permission')
        ->name('list_permission');
    Route::get('/permission/create', 'UserController@permission_create')
        ->name('create_permission');
    Route::post('/permission/create', 'UserController@permission_store')
        ->name('store_permission');
    Route::get('/permission/edit/{role}', 'UserController@permission_edit')
        ->name('edit_permission');
    Route::post('/permission/update/{role}', 'UserController@permission_update')
        ->name('update_permission');
    Route::get('/permission/delete/{permission}', 'UserController@permission_delete')
        ->name('delete_permission');
    Route::get('/permission/list', 'UserController@getPermissions')
        ->name('get_permission');
});

Route::group(['prefix' => 'setting'], function () {
    Route::get('/', 'SettingController@index')
        ->name('list_setting');
    Route::get('/show/{user}', 'SettingController@show')
        ->name('show_setting');
    Route::post('/update/{user}', 'SettingController@update')
        ->name('update_setting');
    Route::get('/search', 'SettingController@search')
        ->name('setting_search');
        Route::get('/list', 'SettingController@getSettings')
        ->name('list_setting2');
    
});

Route::group(['prefix' => 'blend'], function () {
    Route::get('/', 'BlendController@index')
        ->name('list_blend');
    Route::get('/log', 'BlendController@log')
        ->name('log_nhap');
    Route::get('/log2', 'BlendController@getLogs')
        ->name('log2_blend');
    Route::get('/trash', 'BlendController@trash')
        ->name('trash_blend');
    Route::get('/show/{blend}', 'BlendController@show')
        ->name('show_blend');
    Route::get('/create', 'BlendController@create')
        ->name('create_blend');
    Route::post('/create', 'BlendController@store')
        ->name('store_blend');
    Route::get('/edit/{blend}', 'BlendController@edit')
        ->name('edit_blend');
    Route::post('/edit/{blend}', 'BlendController@update')
        ->name('update_blend');
    Route::get('/delete/{blend}', 'BlendController@delete')
        ->name('delete_blend');
    Route::get('/restore/{blend}', 'BlendController@restore')
        ->name('restore_blend');
    Route::get('/forcedelete/{blend}', 'BlendController@forcedelete')
        ->name('forcedelete_blend');
    Route::post('/send/{blend}', 'BlendController@send')
        ->name('send_blend');
    Route::get('/markasread/{blend}', 'BlendController@markAsRead')
        ->name('makasread_blend');
    Route::get('/search', 'BlendController@search')
        ->name('blend_search');
    Route::get('/list2', 'BlendController@getBlends')
        ->name('list2_blend');
    Route::get('/trash2', 'BlendController@getTrashBlends')
        ->name('trash2_blend');
    Route::get('/test', 'BlendController@test')
        ->name('test_blend');
    Route::post('/import', 'BlendController@import')
        ->name('import_blend');
    
});

Route::group(['prefix' => 'congthuc'], function () {
    Route::get('/', 'CongthucController@index')
        ->name('list_congthuc');
    Route::get('/trash', 'CongthucController@trash')
        ->name('trash_congthuc');
    Route::get('/show/{congthuc}', 'CongthucController@show')
        ->name('show_congthuc');
    Route::get('/log/{log}', 'CongthucController@log')
        ->name('log_congthuc');
    Route::get('/log2/{log}', 'CongthucController@getLogs')
        ->name('log2_congthuc');
    Route::get('/log3/{log}', 'CongthucController@getLogDetails')
        ->name('log3_congthuc');
    Route::get('/create', 'CongthucController@create')
        ->name('create_congthuc');
    Route::post('/create', 'CongthucController@store')
        ->name('store_congthuc');
    Route::get('/edit/{congthuc}', 'CongthucController@edit')
        ->name('edit_congthuc');
    Route::post('/edit/{congthuc}', 'CongthucController@update')
        ->name('update_congthuc');
    Route::get('/delete/{congthuc}', 'CongthucController@delete')
        ->name('delete_congthuc');
    Route::get('/restore/{congthuc}', 'CongthucController@restore')
        ->name('restore_congthuc');
    Route::get('/forcedelete/{congthuc}', 'CongthucController@forcedelete')
        ->name('forcedelete_congthuc');
    Route::post('/send/{congthuc}', 'CongthucController@send')
        ->name('send_congthuc');
    Route::get('/markasread/{congthuc}', 'CongthucController@markAsRead')
        ->name('makasread_congthuc');
    Route::get('/list2', 'CongthucController@getCongthucs')
        ->name('list2_congthuc');
    Route::get('/trash2', 'CongthucController@getTrashCongthucs')
        ->name('trash2_congthuc');
    Route::get('/search/{congthuc}', 'CongthucController@search')
        ->name('search_congthuc');
    Route::post('/create2', 'CongthucController@store2')
        ->name('store2_congthuc');
    Route::post('/update_file/{congthuc}', 'CongthucController@update_file')
        ->name('update_file_congthuc');
    Route::get('/download/{congthuc}', 'CongthucController@down')
        ->name('down_congthuc');
    Route::get('/copy/{congthuc}', 'CongthucController@copy')
        ->name('copy_congthuc');
    Route::get('/markasread/{congthuc}', 'CongthucController@markAsRead')
        ->name('markasread_congthuc');
    Route::get('/test', 'CongthucController@test')
        ->name('test_congthuc');
    Route::get('/test2/{congthuc}', 'CongthucController@test2')
        ->name('test2_congthuc');

        
});

Route::group(['prefix' => 'glhl'], function () {
    Route::get('/', 'GLHLController@index')
        ->name('list_glhl');
    Route::get('/trash', 'GLHLController@trash')
        ->name('trash_glhl');
    Route::get('/show/{glhl}', 'GLHLController@show')
        ->name('show_glhl');
    Route::get('/create', 'GLHLController@create')
        ->name('create_glhl');
    Route::post('/create', 'GLHLController@store')
        ->name('store_glhl');
    Route::get('/edit/{glhl}', 'GLHLController@edit')
        ->name('edit_glhl');
    Route::post('/edit/{glhl}', 'GLHLController@update')
        ->name('update_glhl');
    Route::get('/delete/{glhl}', 'GLHLController@delete')
        ->name('delete_glhl');
    Route::get('/restore/{glhl}', 'GLHLController@restore')
        ->name('restore_glhl');
    Route::get('/forcedelete/{glhl}', 'GLHLController@forcedelete')
        ->name('forcedelete_glhl');
    Route::get('/search', 'GLHLController@search')
        ->name('glhl_search');
    Route::get('/list2', 'GLHLController@getGlhls')
        ->name('list2_glhl');
    Route::get('/trash2', 'GLHLController@getTrashGlhls')
        ->name('trash2_glhl');
    Route::post('/import', 'GLHLController@import')
        ->name('import_glhl');
    Route::get('/test', 'GLHLController@test')
        ->name('test_glhl');
    Route::get('/baocao', 'GLHLController@test2')
        ->name('test2_glhl');
    Route::get('/getbaocao', 'GLHLController@getBaocaos')
        ->name('baocao_glhl');
    Route::post('/pdf', 'GLHLController@pdf')
        ->name('pdf_glhl');
});

Route::group(['prefix' => 'xuat'], function () {
    Route::get('/', 'XuatController@index')
        ->name('list_xuat');
    Route::get('/trash', 'XuatController@trash')
        ->name('trash_xuat');
    Route::get('/log', 'XuatController@log')
        ->name('log_xuat');
    Route::get('/show/{log}', 'XuatController@show')
        ->name('show_xuat');
    Route::get('/create', 'XuatController@create')
        ->name('create_xuat');
    Route::post('/create', 'XuatController@store')
        ->name('store_xuat');
    Route::get('/edit/{log}', 'XuatController@edit')
        ->name('edit_xuat');
    Route::post('/edit/{log}', 'XuatController@update')
        ->name('update_xuat');
    Route::get('/delete/{log}', 'XuatController@delete')
        ->name('delete_xuat');
    Route::get('/restore/{log}', 'XuatController@restore')
        ->name('restore_xuat');
    Route::get('/forcedelete/{log}', 'XuatController@forcedelete')
        ->name('forcedelete_xuat');
    Route::get('/list2', 'XuatController@getXuats')
        ->name('list2_xuat');
    Route::get('/trash2', 'XuatController@getTrashXuats')
        ->name('trash2_xuat');
    Route::get('/log2', 'XuatController@getLogs')
        ->name('log2_xuat');
    
    Route::post('/create2', 'XuatController@store2')
        ->name('store2_xuat');
    Route::get('/print/{log}', 'XuatController@print')
        ->name('print_xuat');
    Route::get('/print2/{log}', 'XuatController@print_nhan_gl')
        ->name('print2_xuat');
    Route::get('/print3/{log}', 'XuatController@print_nhan_hl')
        ->name('print3_xuat');
    Route::get('/getQuantityWeek', 'XuatController@getQuantityWeek')
        ->name('getQuantityWeek');
    Route::get('/top5week', 'XuatController@getTop5Week')
        ->name('top5week_xuat');
    Route::get('/top5spweek', 'XuatController@getTop5SpWeek')
        ->name('top5spweek_xuat');
    Route::get('/getQuantitySuppliesWeek', 'XuatController@getQuantitySuppliesWeek')
        ->name('getQuantitySuppliesWeek');

    Route::get('/create2', 'XuatController@create2')
        ->name('create2_xuat');
    Route::post('/create2', 'XuatController@store2')
        ->name('store2_xuat');

    Route::get('/test', 'XuatController@test')
        ->name('test_xuat');

  
    
    
});

Route::group(['prefix' => 'nhap'], function () {
    Route::get('/', 'NhapController@index')
        ->name('list_xuat');
    Route::get('/trash', 'NhapController@trash')
        ->name('trash_nhap');
    Route::get('/log/{log}', 'NhapController@log')
        ->name('log_nhap');
    Route::get('/log2/{log}', 'NhapController@getLogs')
        ->name('log2_nhap');
    Route::get('/log3/{log}', 'NhapController@getLogDetails')
        ->name('log3_nhap');
    Route::get('/show/{log}', 'NhapController@show')
        ->name('show_nhap');
    Route::get('/create', 'NhapController@create')
        ->name('create_nhap');
    Route::post('/create', 'NhapController@store')
        ->name('store_nhap');
    Route::get('/edit/{log}', 'NhapController@edit')
        ->name('edit_nhap');
    Route::post('/edit/{log}', 'NhapController@update')
        ->name('update_nhap');
    Route::get('/delete/{log}', 'NhapController@delete')
        ->name('delete_nhap');
    Route::get('/restore/{log}', 'NhapController@restore')
        ->name('restore_nhap');
    Route::get('/forcedelete/{log}', 'NhapController@forcedelete')
        ->name('forcedelete_nhap');
    Route::get('/list2', 'NhapController@getNhaps')
        ->name('list2_nhap');
    Route::get('/trash2', 'NhapController@getTrashNhaps')
        ->name('trash2_nhap');
    
        
    Route::get('/test', 'NhapController@test')
        ->name('test_nhap');
    Route::get('/test2/{log}', 'NhapController@test2')
        ->name('test2_nhap');
    Route::post('/create2', 'NhapController@store2')
        ->name('store2_nhap');
    Route::get('/print/{log}', 'NhapController@print')
        ->name('print_nhap');
    Route::get('/test/{log}', 'NhapController@test')
        ->name('test_nhap');
});

Route::group(['prefix' => 'log'], function () {
    Route::get('/', 'LogController@index')
        ->name('list_Log');
    Route::get('/show/{user}', 'LogController@show')
        ->name('show_Log');
    
    Route::get('/search', 'LogController@search')
        ->name('Log_search');
    Route::get('/list', 'LogController@getLogs')
        ->name('list_Log2');
    Route::get('/test', 'LogController@test')
        ->name('test_log');
    Route::get('/logauth', 'LogController@LogAuth')
        ->name('logauth');
    Route::get('/logauth2', 'LogController@getLogAuths')
        ->name('logauth2');
});


Route::get('test', function () {
    return view('test2');
});

Route::get('qr', function () {
    return QrCode::size(500)->generate('test');

});

Route::get('download/excel', function()
{
    $test="app/blend_sample.xlsx";
    //dd($test);
    return response()->download($test);
});

Route::get('download/excel2', function()
{
    $test="app/glhl_sample.xlsx";
    //dd($test);
    return response()->download($test);
});
