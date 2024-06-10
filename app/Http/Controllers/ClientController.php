<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Client;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Hash;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    public function add(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'last_name' =>'required|string',
            'rue' =>'required|string',
            'gouvernorat' =>'required|string',
            'delegation' =>'required|string',
            'localite' =>'required|string',
            'ville' =>'required|string',
            'code_postal' =>'required|string',
            'tel' =>'required|string',
            'gsm' =>'required|string',
            'login' =>'required|string',
            'picture' =>'required|string',
            'code_Client' =>'required|string',
            'type_Client' =>'required|string',
        ]);

        $client = Client::create([
            'name' => $fields['name'],
            'last_name' => $fields['last_name'],
            'rue' => $fields['rue'],
            'gouvernorat' => $fields['gouvernorat'],
            'delegation' => $fields['delegation'],
            'localite' => $fields['localite'],
            'ville' => $fields['ville'],
            'code_postal' => $fields['code_postal'],
            'tel' => $fields['tel'],
            'gsm' => $fields['gsm'],
            'login' => $fields['login'],
            'picture' => $fields['picture'],
            'code_Client' => $fields['code_Client'],
            'type_Client' => $fields['type_Client'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $client->createToken('myapptoken')->plainTextToken;

        $response = [
            'Client' => $client,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout()
    {
        //Pour effacer l'entrée de cache de token associée au compte qui s'est déconnecté
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Vous avez été déconnecté avec succès'
        ]);
    }
 


    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'tel' => 'required|string',
            'code_Client' => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ], 422); // Use appropriate HTTP status code for validation errors
        }
    
        // Check client existence
        $client = Client::where('code_Client', $request->code_Client)->first();
    
        if(!$client) {
            return response()->json([
                'message' => 'Informations incorrectes'
            ], 401);
        }
    
        // Assuming $name is a valid field in your Client model
        $clientinfo = $client;
    
        $token = $client->createToken('myapptoken')->plainTextToken;
    
        return response()->json([
            'status' => 200,
            'client' => $clientinfo, 
            'token' => $token,
            'message' => 'Connecté avec succès!',  
        ]);
        }
    

    

      //Pour obtenir l'utilisateur actuellement connecté
      public function getCurrentUser()
      {
          $id = auth()->user()->_id;
          $currentuser = Client::find($id);
          if ($currentuser) {
              return response()->json([
                  'status' => 200,
                  'currentuser' => $currentuser
              ]);
          } else {
              return response()->json([
                  'status' => 404,
                  'message' => 'Aucun utilisateur trouvé'
              ]);
          }
      }
  

      public function resetforgottenpassword(Request $request)
      {
          //validation des requêtes
          $validator = Validator::make($request->all(), [
              'token' => 'required',
              'password' => ['required', 'string', 'confirmed', RulesPassword::defaults()],
          ]);
  
          //Si la validation échoue, une réponse d'erreur sera renvoyée
          if ($validator->fails()) {
              return response()->json([
                  'validation_errors' => $validator->messages()
              ]);
          } else {
              $status = Password::reset(
                  $request->only('password', 'password_confirmation', 'token'),
                  function ($user) use ($request) {
                      $user->forceFill([
                          'password' => Hash::make($request->password),
                          'remember_token' => Str::random(60),
                      ])->save();
  
                      $user->tokens()->delete();
                      event(new PasswordReset($user));
                  }
              );
              if ($status == Password::PASSWORD_RESET) {
                  return response()->json([
                      'status' => 200,
                      'message' => 'Votre mot de passe à été réinitialisé avec succès'
                  ]);
              } else {
                  return response()->json([
                      'status' => 404,
                      'message' => "Mot de passe n'a pas été réinitialisé"
                  ]);
              }
          }
      }


      public function forgotpassword(Request $request)
      {
  
          //validation des requêtes
          $validator = Validator::make($request->all(), [
              'login' => 'required|email'
          ]);
          //Si la validation échoue, une réponse d'erreur sera renvoyée
          if ($validator->fails()) {
              return response()->json([
                  'validation_errors' => $validator->messages()
              ]);
          } else {
              //vérification de l'utilisateur
              $user = Client::where('login', $request->login)->first();
              if (!$user) {
                  return response()->json([
                      'status' => 401,
                      'message' => 'Aucun utilisateur trouvé'
                  ]);
              } else {
                  //envoi d'un lien de vérification par e-mail
                  $status = Password::sendResetLink($request->only('login'));
  
                  if ($status == Password::RESET_LINK_SENT) {
                      return response()->json([
                          'status' => 200,
                          'message' => 'Lien de récupération de mot de passe envoyé avec succès'
                      ]);
                  } else {
                      //si l'e-mail n'a pas été envoyé , une réponse d'erreur sera renvoyée
                      return response()->json([
                          'status' => 404,
                          'message' => "E-mail n'a pas été envoyé "
                      ]);
                  }
              }
          }
      }








}
