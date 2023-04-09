<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\PostController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TagController;
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

Route::get("all-cities", [LocationController::class, "getAllCities"]);


//   AUTHENTICATION --  //
Route::group(["middleware" => 'auth:customer'], function(){
    Route::get("logout", [AuthController::class, "logout"]);
    Route::get("details", [AuthController::class, "details"]);
    Route::post("profile", [AuthController::class], "profile");
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

    Route::group(["prefix" => "customer"], function(){
        Route::post('/skillaction', [SkillController::class, "addSkill"]);
        Route::delete('/skillaction', [SkillController::class, "removeSkill"]);
        Route::post('/create-exp', [CustomerController::class, "createExperience"]);
    });

    Route::group(["prefix" => "company"], function () {
        Route::post("createcompany", [CompanyController::class, "createCompany"]);
        // edit company
        // create company/about
        // edit company/about
        Route::post("/followcompany", [CompanyController::class, "followCompany"]);
        Route::post("/unfollowcompany", [CompanyController::class, "unFollowCompany"]);
    });

    Route::group(["prefix" => "post"], function () {
        Route::post('/createpost', [PostController::class, "createPost"]);
        Route::post("/deletepost", [PostController::class, "deletePost"]);
    });
});

//public routes 

Route::group([], function(){
    // filter homepage posts by city and types
    Route::get("/{city:name}/city", [PostController::class, "postsByCityFilteres"]);
    Route::get("/skills", [SkillController::class, "index"]);
    Route::get("/getcustomers", [CustomerController::class, "getUsers"]);
});

Route::group(["prefix" => "customer"], function(){
    Route::get('/profile',[AuthController::class, "profile"]);
    Route::get('/getskills/{customer:id}', [CustomerController::class, "getSkills"]);
    Route::get('/experiences/{customer:id}', [CustomerController::class, "getExperiences"]);
});

Route::group(["prefix" => "company"], function(){
    Route::get('/{company:id}', [CompanyController::class,  "index"]);
    Route::post('/allcompanies', [CompanyController::class, "getAllCompanies"]);

    Route::post('/getfollowers', [CompanyController::class, "getFollowers"]);
});

Route::group(["prefix" => "posts"], function (){
    Route::get("/", [PostController::class, "getPopularPosts"]);
    Route::get('/new', [PostController::class, "getNewPosts"]);
    Route::get("/popular", [PostController::class, "getPopularPosts"]);
    Route::get('/{customer:id}',[PostController::class, "getUserPosts"]);
});

Route::group(["prefix" => "tags"], function(){
    Route::get('/', [TagController::class, "index"]);
} );


