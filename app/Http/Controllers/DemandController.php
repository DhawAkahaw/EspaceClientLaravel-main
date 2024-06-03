<?php
namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    
    public function add(Request $request) {
        $fields = $request->validate([
            'Reference' => 'required|string',
            'Motif_demand' => 'required|string',
            'Message' => 'nullable|string', 
        ]);

        $fields['Ticket'] = uniqid();  
        $fields['Service'] = 'idk';
        $fields['Desired_Offre'] = $fields['desired_offre'];
        $fields['Motif'] = $fields['Motif_demand'];
        $fields['State'] = 'In progress';  
        $fields['created_at'] = now();
       

        try {
            $demand = Demande::create($fields);
            return response()->json(['demand' => $demand], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create demand', 'error' => $e->getMessage()], 500);
        }
    }
    public function Hisory() {
        $demands = Demande::all(['Ticket', 'Service' , 'Motif' , 'Created_at']);
        return response()->json($demands);
    }

}
