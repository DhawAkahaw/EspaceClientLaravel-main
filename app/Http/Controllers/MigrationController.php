<?php


namespace App\Http\Controllers;

use App\Models\DemandeMigration;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function add(Request $request) {
        $fields = $request->validate([
            'Contract'=>'required|string',
            'current_offre' => 'required|string',
            'desired_offre' => 'required|string',
            
        ]);

            $fields['Ticket'] = uniqid();  
            $fields['Current_offre'] = $fields['current_offre'];
            $fields['Desired_Offre'] = $fields['desired_offre'];
            $fields['GSM'] = $fields['gsm'];
            $fields['Remarque'] = $fields['remarque'];
            $fields['State'] = 'In progress';  
            $fields['created_at'] = now();


        try {
            // Create a new migration with the validated data
            $migration = DemandeMigration::create($fields);
        
            // Return a success response with the newly created migration
            return response()->json(['Migration' => $migration], 201);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during creation
            return response()->json(['message' => 'Failed to create Migration', 'error' => $e->getMessage()], 500);
        }
    }
    public function Hisory() {
        $migration = DemandeMigration::all(['Ticket', 'Current_offre' , 'Desired_Offre' , 'gsm', 'created_at', 'State' , 'Remarque']);
        return response()->json($migration);
    }
}