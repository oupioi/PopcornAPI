<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $like = Like::where('id_user', auth()->user()->id)->get();
        if($like->isEmpty()){
            return response()->json(['message' => 'Vous n\'avez pas encore de like'], 404);
        }else{
            return response()->json($like);
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
        Like::create(
            [
                'id_user' => $validation['id_user'],
                'id_movie' => $validation['id_movie'],

            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
