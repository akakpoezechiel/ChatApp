<?php

// use App\Http\Controllers\AuthController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1.0.0')->group(function() 
{
   Route::post('/register' ,[AuthController::class,'create']);
   Route::post('login',[AuthController::class,'login']);
   Route::post('createGroup',[GroupeController::class,'createGroup']);
   Route::get('allGroupe', [GroupeController::class, 'getAllGroups']);
   Route::post('groupe/{groupId}/addUser', [GroupeController::class, 'addUserToGroup']);
//    Route::post('groupe/{groupId}/addUser', [GroupeController::class, 'sendfile']);
   
   Route::post('file',[FileController::class,'store']);

   Route::get('download/{filename}', [FileController::class, 'download'])->name('file.download');

   Route::get('/groupes/{id}/members', [GroupeController::class, 'showMembers']);



   Route::get('getAllFiles/{groupId}',[FileController::class,'index']);

   route::get('/all_users', [AuthController::class, 'List_user']);



//    Route::get('members', [MemberController::class, 'index']);
Route::get('members/{id}', [MemberController::class, 'show']);
Route::post('members', [MemberController::class, 'store']);
Route::put('members/{id}', [MemberController::class, 'update']);
Route::delete('members/{id}', [MemberController::class, 'destroy']);

Route::delete('files/{id}', [FileController::class, 'destroy']);





    
});