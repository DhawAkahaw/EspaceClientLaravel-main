<?php

namespace App\Http\Controllers;

use App\Models\EnqueteSatisfaction;
use Illuminate\Http\Request;

class EnqueteSatisfactionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question1' => 'required|string',
            'question2' => 'required|string',
            'question3' => 'required|string',
            'question4' => 'required|boolean',
            'question5' => 'required|boolean',
        ]);

        $enqueteSatisfaction = EnqueteSatisfaction::create($validatedData);

        return response()->json(['Migration' => $enqueteSatisfaction ,'message' => 'Migration déposé avec success'], 201);
    }
}
