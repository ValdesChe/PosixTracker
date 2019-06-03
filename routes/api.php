<?php

use Illuminate\Http\Request;
use App\Events\SendPosition;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/publish', function (Request $request) {
    $long = $request->input("longitude");
    $lat = $request->input("latitude");
    
    $location = ["lat" => $lat , "long" => $long];
    event(new SendPosition($location));
    return response()->json(["success" => "success" , "data" => $location]);
});
