<?php
namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    
    public function add(Request $request, $clientId) {
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
        $fields['client_id'] = $clientId;
       

        try {
            $demand = Demande::create($fields);
            return response()->json(['demand' => $demand], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create demand', 'error' => $e->getMessage()], 500);
        }
    }

    public function history($clientId)
    {
        $demands = Demande::where('client_id', $clientId)
            ->select(['Ticket', 'Service', 'Motif', 'created_at' , 'State'])
            ->get();
        return response()->json([
            'status' => 200,
            'demands' => $demands
        ]);
    }
}
