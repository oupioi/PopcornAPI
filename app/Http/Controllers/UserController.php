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

        return response($user, 201);
    }

    public function connexion (Request $request){
        $userRequest = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        //retourne le premier utilisateur qui a le username avec toutes ses informations
       $user =  User::where('username', $userRequest['username'])->first();
       $response = ($user) ? $user : response(['message' => 'Utilisateur non trouvé'], 404);

        if($user && password_verify($userRequest['password'], $user->password)){
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
            'user' => $user,
            'token' => $token,
            ];
        }else{
            $response = response(['message' => 'Mot de passe incorrect'], 401);
        }

       return $response;
     }
}
