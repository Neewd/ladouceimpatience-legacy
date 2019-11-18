<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
	/**
   	* Return true if the email exist or false otherwise.
   	*
   	* @return Response
   	*/
  	public function exist($email) {

    	$user = User::where('email', '=', $email)->first();
      	return response()->json($user);
  	}

    public function verifyEmail(Request $request) {

      $now = Carbon::now();
      $user = User::find(Route::current()->parameter('id'));

      if ($user->email_verified_at !== null) {
        return response()->json(['message' => "L'adresse mail de l'utilisateur à déjà été vérifié"], 401);
      }

      $user->email_verified_at = $now;
      $user->save();

      return response()->json(['message' => "L'adresse mail de l'utilisateur est maintenant vérifié."], 200);

    }
}
