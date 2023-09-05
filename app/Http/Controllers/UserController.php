<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function inscription (Request $request){

        $userRequest = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        
         $user = User::create([
            'username' => $userRequest['username'],
            'email' => $userRequest['email'],
            'password' => bcrypt($userRequest['password']),
         ]);
         if (!$user) {
            return response(['message' => 'Erreur lors de la création de l\'utilisateur', ], 500);
        }else{
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = response(['token' => $token], 201);
        }
        return $response;
    }

    public function connexion (Request $request){
        $userRequest = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
        //retourne le premier utilisateur qui a le username avec toutes ses informations
       $user =  User::where('username', $userRequest['username'])->first();
       $response = ($user) ? $user : response(['message' => 'Utilisateur non trouvé'], 404);

       // statut 200 "OK" si le mot de passe est correct
        if($user && password_verify($userRequest['password'], $user->password)){
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = response(['token' => $token], 200);
        }else{
            // statut 401 "Accès à la ressource interdite" si le mot de passe est incorrect
            $response = response(['message' => 'Mot de passe incorrect'], 401);
        }

       return $response;
     }

     public function deconnexion (Request $request){
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Vous êtes déconnecté'], 200);
     }

     public function getName(){
        $name = auth()->user()->username;
        return response(['name' => $name]);
     }

     public function getNameId(int $id){
        $name = User::find($id)->username;
        return response(['name' => $name]);
    }
}
