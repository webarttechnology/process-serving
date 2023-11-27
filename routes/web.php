<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageManageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServeController;
use App\Http\Controllers\AttornyController;
use App\Http\Controllers\CcaseController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderDetailsController;
use Illuminate\Support\Facades\Session;

Route::view('/', 'client.login')->middleware('check_login');
Route::post('auth', [AdminController::class, 'login']);
Route::get('logout', function () {
    session()->flush();
    session()->flash('success', 'Hurry! Logout Successfully.');
    return redirect('/');
});

Route::post('register', [AdminController::class, 'register']);

Route::controller(PageManageController::class)
    ->middleware(['admin_login'])
    ->group(function () {
        Route::get('dashboard', 'dashboard');
        Route::get('settings', 'settings');
        Route::post('update_payment_method', [AdminController::class, 'update_payment_method'])->name('update_payment_method');
        Route::get('reset_order', [OrderController::class, 'reset_order'])->name('reset_order');
        Route::get('add_case_prev_step', [CcaseController::class, 'previous_step']);
        Route::get('place-order', 'place_order');
        Route::post('update_account_info', [AdminController::class, 'update_info']);
        Route::post('update_password_info', [AdminController::class, 'update_password_info']);
        Route::post('set_session', [ServeController::class, 'set_session']);
        Route::post('add_serve', [ServeController::class, 'add_serve']);
        Route::post('upd_serve', [ServeController::class, 'upd_serve']);
        Route::post('add_address', [ServeController::class, 'add_address']);
        Route::post('add_attorney', [AttornyController::class, 'add_attorney']);
        Route::post('update_attorney', [AttornyController::class, 'update_attorney']);
        Route::get('get_attorney/{name}', [AttornyController::class, 'get_attorney']);
        Route::get('get_case/{ccase}', [CcaseController::class, 'get_case']);
        Route::delete('del_serves/{id}', [ServeController::class, 'del_serves']);
        Route::delete('del-order/{id}', [OrderController::class, 'del_order']);
        Route::post('add_case', [CcaseController::class, 'add_case']);
        Route::post('save_document_step', [DocumentController::class, 'save_document']);
        Route::post('add_document', [DocumentController::class, 'add_document']);
        Route::post('get-options', [DocumentController::class, 'getOptions']);
        Route::delete('del_document/{id}', [DocumentController::class, 'del_document']);
        Route::post('add_d', [DocumentController::class, 'add']);
        Route::post('add_dd', [DocumentController::class, 'addd']);
        Route::post('change_party_lead', [PartyController::class, 'change_party_lead']);
        Route::post('add_party', [PartyController::class, 'add_party']);
        Route::post('add_partyd', [PartyController::class, 'add_partyd']);
        Route::post('edit_party', [PartyController::class, 'edit_party']);
        Route::get('get_party/{id}', [PartyController::class, 'get_party']);
        Route::get('get_party_all_c', [PartyController::class, 'get_party_all_c']);
        Route::get('get_party_all', [PartyController::class, 'get_party_all']);
        Route::delete('del_party/{id}', [PartyController::class, 'del_party']);
        Route::get('check_party/{name}', [PartyController::class, 'check_party']);
        Route::post('order_details', [OrderDetailsController::class, 'order_details']);
        Route::post('final_step', [OrderController::class, 'final_step']);
        Route::post('order_draft', [OrderDetailsController::class, 'order_draft']);
        Route::get('edit-draft-order/{id}', [OrderController::class, 'edit_draft_order'])->name('edit_draft_order');
        Route::get('save-as-draft', [OrderController::class, 'save_as_draft'])->name('save_as_draft');
        Route::get('close-order', 'close_order');
        Route::get('pending-order', 'pending_order');
        Route::get('draft-order', 'draft_order');
        Route::get('users', [UserController::class, 'users'])->name('users');
        Route::get('add-user', [UserController::class, 'add_users'])->name('add_users');
        Route::post('store-user', [UserController::class, 'store_users'])->name('store_users');
        Route::get('edit-user/{id}', [UserController::class, 'edit_users'])->name('edit_users');
        Route::put('update-user/{id}', [UserController::class, 'update_users'])->name('update_users');
        Route::get('delete-user/{id}', [UserController::class, 'delete_users'])->name('delete_users');
        Route::get('account-details/{id}', [UserController::class, 'userDetails'])->name('userDetails');
        Route::post('invite-user', [UserController::class, 'inviteUser'])->name('inviteUser');
    });

Route::get('email-verify/{id}', [AdminController::class, 'verify']);
Route::get('forgot-password/{verifyCode?}', [PageManageController::class, 'forgot_Pass']);
Route::post('forgot-password-action', [PageManageController::class, 'forgot_Pass_action']);
Route::post('change-password-action', [PageManageController::class, 'pass_change_action']);