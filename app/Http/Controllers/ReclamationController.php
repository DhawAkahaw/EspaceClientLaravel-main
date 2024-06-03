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
        $fields['Motif'] = $fields['Motif_rec'];
        $fields['State'] = 'in progress';
        $fields['client_id'] = $clientId;

        try {
            $complain = Reclamation::create($fields);
            return response()->json(['complain' => $complain], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create complain', 'error' => $e->getMessage()], 500);
        }
    }

    public function history($clientId) {
        $reclamations = Reclamation::where('client_id', $clientId)
            ->select(['Ticket', 'Motif', 'gsm', 'created_at', 'State'])
            ->get();
        return response()->json([
            'status' => 200,
            'reclamation' => $reclamations
        ]);
    }
}
