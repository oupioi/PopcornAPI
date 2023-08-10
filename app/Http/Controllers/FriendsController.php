<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Models\User;

class FriendsController extends Controller
{
    /**
     * Avoir tous les noms de mes amis
     */
    public function allFriends()
    {
        $friends = Friends::where('user_id', auth()->user()->id)->get();
        $users = [];
        foreach($friends as $friend){
            $user = User::where('id', $friend->friend_id)->first();
            array_push($users, $user);
        }
        if(count($users) > 0){
            return response()->json($users);
        }else{
            return response()->json(['message' => 'Vous n\'avez pas d\'amis']);
        }
    }

    /**
     *  Rechercher un ami par son prenom
     */
    public function searchFriendByName (Request $request)
    {
        $friends = Friends::where('user_id', $request->user()->id)->get();
        $users = User::where('name', 'like', '%'.$request->name.'%')->get();
        if($users->count() > 0){
            $search = [];
            $friends = Friends::where('user_id', $request->user()->id)->pluck('friend_id')->toArray();
            $users = User::where('name', 'like', '%'.$request->name.'%')->whereIn('id', $friends)->get();
            $search = $users->toArray();
            return response()->json($search);
        }else{
            return response()->json(['message' => 'Aucun utilisateur trouvé']);
        }
    }

    /**
     * Creation d'une amitié
     */
    public function addFriend(Request $request)
    {
        $friend = new Friends();
        if($request->user()->id == $request->friend_id){
            return response()->json(['message' => 'Vous ne pouvez pas vous ajouter en ami']);
        }else if(Friends::where('user_id', $request->user()->id)->where('friend_id', $request->friend_id)->count() > 0){
            return response()->json(['message' => 'Vous êtes déjà amis']);
        }else{
            $friend->user_id = $request->user()->id;
            $friend->friend_id = $request->friend_id;
            if($friend->save()){
                return response()->json(['message' => 'Ami ajouté']);
            }else{
                return response()->json(['message' => 'Erreur lors de l\'ajout de l\'ami']);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Friends $friends)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friends $friends)
    {
        //
    }

    /**
     * Supprimer un ami
     */
    public function destroy(int $id)
    {
        if(Friends::where('friend_id', $id)->delete()){
            return response()->json(['message' => 'Ami supprimé']);
        }
    }
}
