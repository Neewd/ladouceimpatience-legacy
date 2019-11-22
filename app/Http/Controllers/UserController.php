<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\User;
use Debugbar;
use Carbon\Carbon;

class UserController extends Controller
{
  /**
   * Return true if the email exist or false otherwise.
   *
   * @return Response
   */
  public function exist($email)
  {
    $user = User::where('email', '=', $email)->first();
    Debugbar::info($user);
    return response()->json($user);
  }

  public function verifyEmail(Request $request)
  {

    $now = Carbon::now();
    $user = User::find(Route::current()->parameter('id'));

    if ($user->email_verified_at !== null) {
      return response()->json(['message' => "L'adresse mail de l'utilisateur à déjà été vérifié"], 401);
    }

    $user->email_verified_at = $now;
    $user->save();

    return response()->json(['message' => "L'adresse mail de l'utilisateur est maintenant vérifié."], 200);
  }

  public function sendResetPassword(Request $request)
  {
    $user = User::where('email', '=', $request->email)->first();
    if (!$user) { } else {
      $random_token = Str::random(80);
      $user->resend_token = $random_token;
      $user->save();
      Mail::to($request->email)->send(new ResetPasswordMail($request->email, $user->resend_token));
    }
    return response()->json(['message' => "Si l'adresse mail existe vous devriez recevoir un mail très prochainement"], 200);
  }

  public function modifyPassword(Request $request)
  {
    $rules = array(
      'password' => 'required|min:8|confirmed',
      'token'   => 'required'
    );

    $messages = [
      'password.required' => "Un nouveau mot de passe est nécessaire n'est-ce pas ?",
      'password.min' => "Le mot de passe doit être de minimum 8 caractères.",
      'password.confirmed' => "Les mots de passe ne sont pas les mêmes.",
      'token.required' => "Il manque un token."
    ];

    Debugbar::info($request->all());
    $this->validate($request, $rules, $messages);

    $user = User::where('resend_token', '=', $request->token)->first();

    if (!$user) {
      return response()->json("Aucun utilisateur n'est associé à ce token.", 404);
    } else {
      $user->fill([
        'password' => Hash::make($request->password),
        'resend_token' => ''
      ])->save();

      return response()->json("Le mot de passe vient d'être modifé.", $this->successStatus);
    }
  }
}
