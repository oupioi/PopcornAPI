<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $history = History::where('id_user', auth()->user()->id)->get();
        if($history->isEmpty()){
            return response()->json(['message' => 'Vous n\'avez pas encore d\'historique'], 404);
        }else{
            return response()->json($history);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate(
            [
                'id_user' => 'required | integer',
                'id_movie' => 'required | integer',
            ]);
        $history = History::create(
            [
                'id_user' => $validation['id_user'],
                'id_movie' => $validation['id_movie'],

            ]
        );
        if($history){
            return response()->json(['message' => 'Historique créé'], 201);
        }else{
            return response()->json(['message' => 'Erreur lors de la création de l\'historique'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
       return History::where('id_user', auth()->user()->id)->where('id_movie', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        $history->delete();
        return response()->json(['message' => 'Historique supprimé'], 200);
    }
}
