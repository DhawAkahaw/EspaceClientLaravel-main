<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;

use Illuminate\Http\Request;

class SuggController extends Controller
{
    public function add(Request $request) {
        $fields = $request->validate([
            'Sugg_context' => 'required|string',
            'Subject' => 'required|string',
            'Message' => 'required|string', 
            
        ]);
        $fields['Ticket'] = uniqid();  
        $fields['Subject'] = $fields['subject']; 
        $fields['created_at'] = now();
    
        try {
            // Create a new demand with the validated data
            $sug = Suggestion::create($fields);
    
            // Return a success response with the newly created demand
            return response()->json(['demand' => $sug], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during creation
            return response()->json(['message' => 'Failed to create suggestion', 'error' => $e->getMessage()], 500);
        }
    }
    public function History() {
        $reclamations = Suggestion::all(['Ticket', 'Subject' , 'created_at' ]);
        return response()->json($reclamations);
    }
}
