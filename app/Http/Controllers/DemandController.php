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
        $fields['State'] = 'In progress';
        
        $fields['client_id'] = $clientId;  // Add the client ID

        try {
            $demand = Demande::create($fields);
            return response()->json(['demand' => $demand], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create demand', 'error' => $e->getMessage()], 500);
        }
    }

   public function history($clientId) {
        $demands = Demande::where('client_id', $clientId)
            ->select(['Ticket', 'Service', 'Motif_demand', 'created_at', 'State'])
            ->get();
        return response()->json([
            'status' => 200,
            'demands' => $demands
        ]);
    }
    

}
