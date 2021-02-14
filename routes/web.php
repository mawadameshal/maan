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
    $itemco=\App\Company::all()->first();
    return view('welcome',compact('itemco'));
});



///account/company/2/edit noaccses
Route::get('/noaccses',function (){
    $itemco=\App\Company::all()->first();
    return view('citizen.noaccses',compact('itemco'));
});
////منع البوست
Route::get('/account/login',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/restpassord',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/home/change-password-post',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/account/profileup/{id}',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/account/permission-post/{id}',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/account/select-project-post/{id}',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/project/importcitizentoproject/{id}',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/citizen/importcitizen',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/citizen/select-project-post/{id}',function (){$itemco=\App\Company::all()->first();return view('welcome',compact('itemco'));});
Route::get('/account/circle/select-category-post/{id}',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/account/form/addreplay/{id}',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/citizen/savenew',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::post('/citizen/saverecommendations',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/citizen/saveolde/{id}',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/forms/formsavenew',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/forms/formsaveolde/{id}',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/forms/addfollow',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
Route::get('/forms/addevaluate',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
//Route::get('/account/events',function (){$itemco=\App\Company::all()->first(); return view('welcome',compact('itemco')); });
//////
Route::get('/account','Account\HomeController@dashboard');
Route::get('/account/home/dashboard','Account\HomeController@dashboard');
Route::get('/account/home/noaccess','Account\HomeController@noaccess');
Route::get('/account/home/change-password','Account\HomeController@changePassword');
Route::post('/account/home/change-password-post','Account\HomeController@changePasswordPost');
Route::resource("/account/company","Account\CompanyController");
Route::resource("/account/message","Citizen\MessageController");
Route::get('/account/message/delete/{id}','Citizen\MessageController@destroy');
Route::get('/back','Account\HomeController@backup');

//الاجازات
Route::get('/account/events', 'Account\EventController@index')->name('events.index');
Route::post('/account/events', 'Account\EventController@addEvent')->name('events.add');
Route::get('/account/events/edit/{id}', 'Account\EventController@edit')->name('events.edit');
Route::get('/account/events/update/{id}', 'Account\EventController@update')->name('events.update');
Route::get('/account/events/delete/{id}', 'Account\EventController@destory')->name('events.destory');


Route::post('/back','Account\HomeController@backup');
///لوجين ونسيت
///
Route::post('/account/login','AuthController@ajaxlogin');
Route::post('/account/restpassord','AuthRestController@sendResetLinkEmail');

//ادارة الحسابات
//
Route::get('/account/account/permission/{id}','Account\AccountController@permission');
Route::get('/account/account/profile/{id}','Account\AccountController@profile');
Route::patch('/account/account/profileup/{id}','Account\AccountController@profileup');
Route::resource("/account/account","Account\AccountController");
Route::get('/account/account/delete/{id}','Account\AccountController@destroy');
Route::post('/account/account/permission-post/{id}','Account\AccountController@permissionPost');
Route::get('/account/account/select-project/{id}','Account\AccountController@selectproject');
Route::post('/account/account/select-project-post/{id}','Account\AccountController@selectprojectPost');
//Route::get('/account/account/formtoaccount/{id}','Account\AccountController@formtoaccount');
Route::get('/account/account/forminaccount/{id}','Account\AccountController@forminaccount');
//ادارة المشاريع
Route::post('/account/project/importcitizentoproject/{id}','Account\ProjectController@import');
Route::resource("/account/project","Account\ProjectController");
Route::get('/account/project/delete/{id}','Account\ProjectController@destroy');
Route::get('/account/project/active/{id}','Account\ProjectController@active');
Route::get('/account/project/citizeninproject/{id}','Account\ProjectController@citizeninproject');
Route::get('/account/project/forminproject/{id}','Account\ProjectController@forminproject');
Route::get('/account/project/accountinproject/{id}','Account\ProjectController@accountinproject');
Route::get('/account/project/stuffinproject/{id}','Account\ProjectController@stuffinproject');
Route::post('/account/project/stuffinproject/{id}','Account\ProjectController@stuffinprojectPost');
//منطقة الرسومات
Route::get('/account/charts','Account\ChartsController@citizenstoprojects');
Route::get('/account/charts/formstoprojects','Account\ChartsController@formstoprojects');
Route::get('/account/charts/formstocatigoreis','Account\ChartsController@formstocatigoreis');
//ادارة المواطنين
// Route::post('/account/citizen/importcitizen','Account\CitizenController@import');
Route::resource("/account/citizen","Account\CitizenController");
Route::get('/account/citizen/delete/{id}','Account\CitizenController@destroy');
Route::get('/account/citizen/select-project/{id}','Account\CitizenController@selectproject');
Route::post('/account/citizen/select-project-post/{id}','Account\CitizenController@selectprojectPost');
Route::get('/account/citizen/accept/{id}','Account\CitizenController@accept');
Route::get('/account/citizen/formincitizen/{id}','Account\CitizenController@formincitizen');
Route::get('/get-citizen-data','Account\CitizenController@get_citizen_data')->name('get-citizen-data');
Route::get('/download-citizen-file','Account\CitizenController@download_citizen_file')->name('download-citizen-file');
Route::get('/download-sample-file','Account\MessageController@download_sample_file')->name('download-sample-file');
Route::post('/account/citizen/importcitizen','Account\CitizenController@save_citizen_data')->name('save-citizen-data');
Route::post('/account/citizen/importcitizen/{id}','Account\ProjectController@import')->name('save-citizen-data-project');
Route::get('/notbenfit','Account\CitizenController@not_benefit')->name('not_benefit');

//ادارة الاشعارات

Route::resource("/account/notifications/", "Account\NotificationController");
//SMS
Route::resource("/account/message", "Account\MessageController");

Route::post('/account/message/importmessage','Account\messageController@send_group_messages')->name('send_group_messages');
Route::post('/account/message/send_single_message','Account\messageController@send_single_message')->name('send_single_message');

//ادارة الفئات
Route::resource("/account/category","Account\CategoryController");
Route::get("/account/category/showcircle/{id}","Account\CategoryController@showcircle");
Route::post("account/category/get_categories/{is_complaint}","Account\CategoryController@get_categories");

Route::resource("/account/suggest","Account\SuggestController");
Route::get('/account/category/delete/{id}','Account\CategoryController@destroy');
Route::post('/account/category/update/{id}','Account\CategoryController@update');

//ادارة الدوائر
Route::resource("/account/circle","Account\CircleController");
Route::get('/account/circle/delete/{id}','Account\CircleController@destroy');
Route::get('/account/circle/select-category/{id}','Account\CircleController@selectcategory');
Route::post('/account/circle/select-category-post/{id}','Account\CircleController@selectcategoryPost');

//ادارة النماذج
Route::post('/account/form/delete','Account\FormController@destroy')->name('delete_form');
Route::post('/account/form/destroy_from_citizian','Account\FormController@destroy_from_citizian')->name('destroy_from_citizian');
Route::resource("/account/form","Account\FormController");
Route::get("/download_form_file/{id}","Account\FormController@download_form_file")->name('download_form_file');

Route::get("/account/deleted_form","Account\FormController@deleted_form");
Route::get('/account/form/delete/{id}','Account\FormController@destroy');
Route::post('/account/form/addreplay/{id}','Account\FormController@addreplay');
Route::get('/account/form/terminateform/{id}','Account\FormController@terminateform');
Route::get('/account/form/allowform/{id}','Account\FormController@allowform');
Route::post('/account/form/change-category/{id}','Account\FormController@changecategory');

Route::post('/account/form/clarification_from_citizian/{id}','Account\FormController@clarification_from_citizian');

Route::post('/account/form/change_response/{id}','Account\FormController@change_response')->name('change_response');
Route::post('/account/form/change_response_and_update_form_data/{id}','Account\FormController@change_response_and_update_form_data')->name('change_response_and_update_form_data');
Route::post('/account/form/update_form_data/{id}','Account\FormController@update_form_data')->name('update_form_data');


//عرض النموذج وردوده ومتابعته
Route::get('/citizen/form/show/{ido}/{id}','Citizen\FormController@show');
Route::get('/citizen/form/show1/{ido}/{id}','Citizen\FormController@show1');
Route::post('/citizen/form/save_form_followup/{id}','Citizen\FormController@save_form_followup')->name('save_form_followup');

Route::get('/account/form/showfiles/{id}','Account\FormController@showfiles')->name('showfiles');
Route::get('/citizen/form/showfiles/{id}','Citizen\FormController@showfiles')->name('citizenshowfiles');
/////////////////المواطن
//اضافة النماذج
Route::get('/citizen/form/searchbeforadd/{type}','Citizen\CitizenController@searchbyidnum');
Route::get('/citizen/getproject','Citizen\CitizenController@gethisproject');
Route::get('/citizen/editorcreatcitizen','Citizen\CitizenController@editorcreatcitizen');
Route::post('/citizen/savenew','Citizen\CitizenController@store');
Route::post('/citizen/saverecommendations','Citizen\FormController@saverecommendations');
Route::patch('/citizen/saveolde/{id}','Citizen\CitizenController@update');
Route::get('/form/addform/{type}/{citzen_id}/{project_id}','Citizen\FormController@addform');
Route::post('/forms/formsavenew','Citizen\FormController@formstore');
Route::get('/form/confirm/{id}','Citizen\FormController@confirmform');

//Route::get('/form/editform/{id}','Citizen\FormController@editform');
Route::patch('/forms/formsaveolde/{id}','Citizen\FormController@formupdate');
Route::get('/citizen/form/delayform/{id}','Citizen\FormController@delayform');
//متابعة النماذج
Route::get('/citizen/form/search','Citizen\FormController@searchbyidnumorform');
Route::get('/citizen/form/getforms','Citizen\FormController@getforms');
Route::post('/forms/addfollow','Citizen\FormController@addfollow');
Route::post('/forms/addevaluate','Citizen\FormController@addevaluate');
    //Auth::routes();
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Authentication Routes...
Route::get('login', function () {
    $itemco=\App\Company::all()->first();
    return view('welcome',compact('itemco'));
})->name('login');

Route::get('logout', function () {
    $itemco=\App\Company::all()->first();
    return view('welcome',compact('itemco'));
});

Route::post('login', 'Auth\LoginController@login');
Route::middleware('auth')->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register',  function () {
    $itemco=\App\Company::all()->first();
    return view('welcome',compact('itemco'));
})->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', function () {
    $itemco=\App\Company::all()->first();
    return view('welcome',compact('itemco'));
})->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');








