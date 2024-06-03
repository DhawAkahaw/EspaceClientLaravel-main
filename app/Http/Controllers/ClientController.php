<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Client;

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
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id); // Find the client by ID
        
        // Update the client's information
        $data = $request->except('picture'); // Exclude picture from the data
        
        if ($request->hasFile('picture')) {
            $path = $client->picture;
            if (File::exists($path)) {

                File::delete($path);
            }
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('img/client/', $filename);
            $client->picture = 'img/client/' . $filename;
        }

        
        $client->update($data);
        
        return response()->json(['message' => 'Mise à jour du profil réussie'], 200);
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
  
}
