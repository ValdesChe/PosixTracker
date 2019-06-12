<?php


use Illuminate\Http\Request;
use App\Events\SendPosition;
use App\Location;
use Carbon\Carbon;
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


Route::get('/publish', function (Request $request) {
    

    // Verification du formulaire
/*    $validation = validateRequest($request);
    if(!$validation){
        return $validation;
    }*/

    $long = $request->input("longitude");
    $lat = $request->input("latitude");
    
    $location = ["lat" => $lat , "long" => $long];

    // Construction du nouvel objet
    $location  = new Location();
    $location->description = $request->input("description");
    $location->longitude = $long;
    $location->latitude = $lat;


    // Si sauvegardé en BD on publie la position dans le Pusher
    if ($location->save()) {
        event(new SendPosition($location));
        return response()->json(["status" => "success" , "data" => $location], 200);
    }
    // On renvoie une erreur 
    return response()->json(["status" => "error" , "message" => "Unable to save the location in server !"], 422);
});



Route::post('/all', function (Request $request) {

    // Toutes les positions enregistrées par le robot
    $locations = Location::all();
    return response()->json(["success" => "success" , "all_locations" => $locations]);
});


Route::post('/today', function (Request $request) {

    // Toutes les positions enregistrées par le robot
    $locations = Location::whereDate('created_at', Carbon::today())->get();
    return response()->json(["success" => "success" , "all_locations" => $locations]);
});

Route::post('/special_day', function (Request $request) {
    if( Carbon::now()->lessThan($request->start_date)){
        // On renvoie une erreur 
        return response()->json(["status" => "error" , "message" => "La date choisie est indisponible !"], 422);
    }
    // Toutes les positions enregistrées par le robot
    $locations = Location::whereDate('created_at', Carbon::today())->get();
    return response()->json(["success" => "success" , "all_locations" => $locations]);
});


    /**
     * Validate Request when Creating or Updating a Car
     * 
     */
    function validateRequest(Request $request)
    {
            $rule = [
                'description' => ['string', 'min:2', 'max:191'],
                'longitude' => ['required', 'numeric'],
                'latitude' => ['required', 'numeric']
            ];
        
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()){
            return response()->json(["message" => $validator->messages()->toArray()], 422);
        }
        return true;
    }


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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::get('/', function () {
  // return response()->json(["success" => "success" , "all_locations" => 15]); 
   return view('welcome');
});
