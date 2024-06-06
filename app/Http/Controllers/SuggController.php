<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggController extends Controller
{
    public function add(Request $request, $clientId) {
        $fields = $request->validate([
            'Sugg_context' => 'required|string',
            'Subject' => 'required|string',
            'Message' => 'required|string', 
        ]);

        $fields['Ticket'] = uniqid();  
        $fields['client_id'] = $clientId;
    
        try {
            // Create a new suggestion with the validated data
            $sug = suggestion::create($fields);
    
            // Return a success response with the newly created suggestion
            return response()->json(['message' => 'Suggestions déposé avec success','suggestion' => $sug], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during creation
            return response()->json(['message' => 'Failed to create suggestion', 'error' => $e->getMessage()], 500);
        }

        
    }

    public function history($id)
    {
        $suggestion = Suggestion::where('client_id', $id)->get();
        return response()->json([
            'status' => 200,
            'suggestion' => $suggestion
        ]);
    }

   
        
    public function login(Request $request) {
        
    
        $demand = Suggestion::where('code_Client', $request->code_Client)->first();
    
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

}
