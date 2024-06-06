<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function add(Request $request, $clientId) {
        $fields = $request->validate([
            'mail' => 'required|string',
            'domaine' => 'required|string',
            'mail_rec' => 'nullable|string',
            'pass' => 'required|string',
        ]);
        
        $fields['State'] = 'Actif';  
        $fields['client_id'] = $clientId;

        try {
            // Create a new demande transfert ligne with the validated data
            $mail = Email::create($fields);
        
            // Return a success response with the newly created demande transfert ligne
            return response()->json(['mail' => $mail ,'message' => 'Migration déposé avec success'], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during creation
            return response()->json(['message' => 'Failed to create DemandeTransfertLigne', 'error' => $e->getMessage()], 500);
        }
    }

    public function maillist($id)
    {
        $mail = Email::where('client_id', $id)->get();
        return response()->json([
            'status' => 200,
            'mail' => $mail
        ]);
    }

   
        
    public function login(Request $request) {
        
    
        $mail = Email::where('code_Client', $request->code_Client)->first();
    
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
