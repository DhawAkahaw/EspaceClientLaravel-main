<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\DemandeTransfertLigneController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\LineController;
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

Route::post('/log', [ClientController::class, 'login']);
Route::get('/Reclamations_history/{clientId}', [ReclamationController::class, 'history']);
Route::post('/Submitreclamation/{id}', [ReclamationController::class, 'add']);
Route::post('/Submitline/{id}', [LineController::class, 'add']);
Route::get('/LineHistory/{clientId}', [LineController::class, 'history']);
// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //Client
    Route::post('/add', [ClientController::class, 'add']);
    
    Route::post('/logout', [ClientController::class, 'logout']);
    Route::post('/update_profile/{id}', [ClientController::class, 'update']);
    Route::get('/currentuser', [ClientController::class, 'getCurrentUser']);
    //Facture
    Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
    Route::get('/factures/{clientId}', [FactureController::class, 'monf']);
    //Demand
    Route::post('/Submitdemand/{id}', [DemandController::class, 'add']);
    Route::get('/Demands/{clientId}', [DemandController::class, 'history']);
    
    //Complain-reclamation
    Route::get('/Reclamations_history/{clientId}', [ReclamationController::class, 'history']);
    Route::post('/Submitreclamation/{id}', [ReclamationController::class, 'add']);
    //Migration
    Route::post('/Submitmigration/{id}', [MigrationController::class, 'add']);
    Route::get('/Migrations_history/{clientId}', [MigrationController::class, 'history']);
    //Line
   
    //Sugg
    Route::post('/Submitsuggestion', [Suggestion::class, 'add']);
    Route::get('/SuggestionsHistory/{clientId}', [Suggestion::class, 'History']);



});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});