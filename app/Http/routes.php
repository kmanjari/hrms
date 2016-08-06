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

//Route::group(['middleware' => ['web']], function () {


    Route::group(['middleware' => ['guest']], function()
    {
        Route::get('/', 'AuthController@showLogin');

        Route::post('/', 'AuthController@doLogin');

        Route::get('register','AuthController@doRegister');
    });


    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('logout', 'AuthController@doLogout');

        Route::get('welcome','AuthController@welcome');

        Route::get('error','AuthController@error');

        Route::get('dashboard', 'AuthController@dashboard');

        Route::get('add-employee',['as' => 'add-employee', 'uses' => 'EmpController@addEmployee']);

        Route::post('add-employee',['as' => 'add-employee', 'uses' =>'EmpController@processEmployee']);

        Route::get('employee-manager',['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);

        Route::post('employee-manager', 'EmpController@searchEmployee');

        Route::get('upload-emp',['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);

        Route::post('upload-emp',['as' => 'upload-emp', 'uses' =>'EmpController@uploadFile']);

        Route::get('edit-emp/{id}' ,['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);

        Route::post('edit-emp/{id}' ,['as' => 'edit-emp', 'uses' =>'EmpController@doEdit']);

        Route::get('delete-emp/{id}' ,['as' => 'delete-emp', 'uses' =>'EmpController@doDelete']);

        Route::get('add-team' ,['as' => 'add-team', 'uses'=>'TeamController@addTeam']);

        Route::post('add-team',['as' => 'add-team', 'uses'=>'TeamController@processTeam']);

        Route::get('team-listing',['as' => 'team-listing', 'uses' =>'TeamController@showTeam']);

        Route::get('edit-team/{id}',['as' => 'edit-team', 'uses' => 'TeamController@showEdit']);

        Route::post('edit-team/{id}',['as' => 'edit-team', 'uses' =>'TeamController@doEdit']);

        Route::get('delete-team/{id}',['as' => 'delete-team', 'uses' =>'TeamController@doDelete']);


        Route::get('add-role',['as' => 'add-role', 'uses'=>'RoleController@addRole']);

        Route::post('add-role',['as' => 'add-role', 'uses'=>'RoleController@processRole']);

        Route::get('role-list',['as' => 'role-list', 'uses'=>'RoleController@showRole']);

        Route::get('edit-role/{id}', ['as' => 'edit-role', 'uses'=>'RoleController@showEdit']);

        Route::post('edit-role/{id}',['as' => 'edit-role', 'uses'=>'RoleController@doEdit']);

        Route::get('delete-role/{id}',['as' => 'delete-role', 'uses'=>'RoleController@doDelete']);

        Route::get('add-leave-type',['as' => 'add-leave-type', 'uses'=>'LeaveController@addLeaveType']);

        Route::post('add-leave-type',['as' => 'add-leave-type', 'uses'=>'LeaveController@processLeaveType']);

        Route::get('leave-type-listing' ,['as' => 'leave-type-listing', 'uses'=>'LeaveController@showLeaveType']);

        Route::get('edit-leave-type/{id}',['as' => 'edit-leave-type', 'uses'=>'LeaveController@showEdit']);

        Route::post('edit-leave-type/{id}',['as' => 'edit-leave-type', 'uses'=>'LeaveController@doEdit']);

        Route::get('delete-leave-type/{id}',['as' => 'delete-leave-type', 'uses'=>'LeaveController@doDelete']);

        Route::get('apply-leave' ,['as' => 'apply-leave', 'uses'=>'LeaveController@doApply']);

        Route::post('apply-leave' ,['as' => 'apply-leave', 'uses'=>'LeaveController@processApply']);

        Route::get('my-leave-list' ,['as' => 'my-leave-list', 'uses'=>'LeaveController@showMyLeave']);

        Route::get('total-leave-list' ,['as' => 'total-leave-list', 'uses'=>'LeaveController@showAllLeave']);

        Route::post('total-leave-list', 'LeaveController@searchLeave');

        Route::get('leave-drafting', ['as' => 'leave-drafting', 'uses'=>'LeaveController@showLeaveDraft']);

        Route::post('leave-drafting',  ['as' => 'leave-drafting', 'uses'=>'LeaveController@createLeaveDraft']);

        Route::get('attendance-manager',['as' => 'attendance-manager', 'uses' => 'AttendanceController@importAttendanceFile']);

        Route::post('attendance-manager',['as' => 'attendance-manager', 'uses' => 'AttendanceController@uploadFile']);

        Route::get('delete-file/{id}',['as' => 'delete-file', 'uses' =>'AttendanceController@doDelete']);

        Route::get('add-asset',['as' => 'add-asset', 'uses' =>'AssetController@addAsset']);

        Route::post('add-asset',['as' => 'add-asset', 'uses' =>'AssetController@processAsset']);

        Route::get('asset-listing',['as' => 'asset-listing', 'uses' =>'AssetController@showAsset']);

        Route::get('edit-asset/{id}', ['as' => 'edit-asset', 'uses' =>'AssetController@showEdit']);

        Route::post('edit-asset/{id}',['as' => 'edit-asset', 'uses' =>'AssetController@doEdit']);

        Route::get('delete-asset/{id}',['as' => 'delete-asset', 'uses' =>'AssetController@doDelete']);

        Route::get('assign-asset',['as' => 'assign-asset', 'uses' =>'AssetController@doAssign']);

        Route::post('assign-asset',['as' => 'assign-asset', 'uses' =>'AssetController@processAssign']);

        Route::get('assignment-listing',['as' => 'assignment-listing', 'uses' =>'AssetController@showAssignment']);

        Route::get('edit-asset-assignment/{id}',['as' => 'edit-asset-assignment', 'uses' => 'AssetController@showEditAssign']);

        Route::post('edit-asset-assignment/{id}',['as' => 'edit-asset-assignment', 'uses' =>'AssetController@doEditAssign']);

        Route::get('delete-asset-assignment/{id}',['as' => 'delete-asset-assignment', 'uses' =>'AssetController@doDeleteAssign']);

        Route::get('hr-policy', ['as' => 'hr-policy', 'uses' =>'IndexController@showPolicy']);

        Route::get('download-forms', ['as' => 'download-forms', 'uses' =>'IndexController@showForms']);

        Route::get('download/{name}','DownloadController@downloadForms');

        Route::get('calendar','AuthController@calendar');
    });

    Route::get('textig', 'TeamController@test');

    Route::get('password', function()
    {
        $dateToday = date('Y-m-d');
        $users = \App\Models\Employee::whereRaw("DATE_FORMAT(`dob`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();
        return $users;
    });


Route::get('checkBase', function()
{
    return \Auth::user()->employee->id;
}
);
//});


