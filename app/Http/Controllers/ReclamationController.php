<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    public function add(Request $request, $clientId) {
        $fields = $request->validate([
            'offre' => 'required|string',
            'Service' => 'required|string',
            'Category' => 'required|string',
            'Motif_rec' => 'required|string',
            'Image' => 'nullable|string',
            'gsm' => 'required|string',
            'Message' => 'required|string',
        ]);

        $fields['Ticket'] = uniqid();
        $fields['State'] = 'in progress';
        $fields['client_id'] = $clientId;

        try {
            $complain = Reclamation::create($fields);
            return response()->json(['complain' => $complain], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create complain', 'error' => $e->getMessage()], 500);
        }
    }

   
   
        
    public function history($id)
    {
        $reclamation = Reclamation::where('client_id', $id)->get();
        return response()->json([
            'status' => 200,
            'reclamation' => $reclamation
        ]);
    }

   
        
    public function login(Request $request) {
        
    
        $rec = Reclamation::where('code_Client', $request->code_Client)->first();
    
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
