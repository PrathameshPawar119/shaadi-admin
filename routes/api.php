<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Customer\PostController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//   AUTHENTICATION --  //
Route::group(["middleware" => 'auth:customer'], function(){
    Route::get("logout", [AuthController::class, "logout"]);
    Route::get("details", [AuthController::class, "details"]);
});

Route::group(["prefix" => "auth"], function(){
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
});

Route::post("/sendotp", [OtpController::class, "sendOtp"]);
Route::post("/verifyotp", [OtpController::class, "verifyOtp"]);
//  -- AUTHENTICATION   //   


// Protected action routes

Route::group(["middleware" => 'auth:customer'], function (){
    Route::group(["prefix" => "company"], function () {
        Route::post("createcompany", [CompanyController::class, "createCompany"]);
        // edit company
        // create company/about
        // edit company/about
    });

    Route::group(["prefix" => "post"], function () {
        Route::post('/createpost', [PostController::class, "createPost"]);
        Route::post("/deletepost", [PostController::class, "deletePost"]);
    });
});

//public routes 

Route::group(["prefix" => "company"], function(){
    Route::get('/{company:id}', [CompanyController::class,  "index"]);
    Route::get('/allcompanies', [CompanyController::class, "getAllCompanies"]);
});

Route::group(["prefix" => "post"], function (){
    Route::get('/', [PostController::class, "getAllPosts"]);
    Route::get('/{customer:id}',[PostController::class, "getUserPosts"]);
});

