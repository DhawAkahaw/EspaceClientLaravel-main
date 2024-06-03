<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\DemandeTransfertLigneController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\ReclamationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;
use App\Models\Suggestion;

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
/*Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/add', [ClientController::class, 'add']);
Route::post('/log', [ClientController::class, 'login']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
oute::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('products', ProductController::class);
*/

// Public routes

Route::post('/addf', [FactureController::class, 'add']);
Route::get('/sanctum/csrf-cookie', [ClientController::class, 'getCSRFCookie']);




// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Client
    Route::post('/logout', [ClientController::class, 'logout']);
    Route::post('/update_profile/{id}', [ClientController::class, 'update']);
    Route::get('/currentuser', [ClientController::class, 'getCurrentUser']);
    //Facture
    Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
    Route::get('/factures/{clientId}', [FactureController::class, 'monf']);
    //Demand
    Route::get('/Demands_history', [DemandController::class, 'History']);
    Route::post('/Submitdemand', [DemandController::class, 'add']);
    //Complain-reclamation
    Route::get('/Reclamations_history', [ReclamationController::class, 'History']);
    Route::post('/Submitreclamation', [ReclamationController::class, 'add']);
    //Migration
    Route::post('/Submitmigration', [MigrationController::class, 'add']);
    Route::get('/Migrations', [MigrationController::class, 'History']);
    //Line
    Route::post('/Submitline', [DemandeTransfertLigneController::class, 'add']);
    Route::get('/LineHistory', [DemandeTransfertLigneController::class, 'History']);
    //Sugg
    Route::post('/Submitsuggestion', [Suggestion::class, 'add']);
    Route::get('/SuggestionsHistory', [Suggestion::class, 'History']);
    


});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});