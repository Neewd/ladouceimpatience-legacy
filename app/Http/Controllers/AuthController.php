<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Validator;
use Debugbar;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email' => 'required|email',
            'password' => 'required | confirmed',
            'phone' => 'required',
            'gender' => 'required',
            'birth_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        Mail::to($user->email)->send(new VerifyMail($user));

        return response()->json(['message' => 'The user has been register, a verification mail has been sent.'], $this->successStatus);
    }

    public function login(Request $request)
    {

        $email = $request->email;
        $password = $request->password;
        $request->request->add([
            'username' => $email,
            'password' => $password,
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET')
        ]);

        $tokenRequest = Request::create(
            env('APP_URL') . '/oauth/token',
            'post'
        );

        $response = Route::dispatch($tokenRequest);

        if ($response->getStatusCode() == 200) {
            return $response->getContent();
        } else if ($response->getStatusCode() == 400) {
            return response()->json('Invalid request, please enter a username and a password.', $response->getStatusCode());
        } else if ($response->getStatusCode() == 401) {
            return response()->json('Your credentials are incorrect.', $response->getStatusCode());
        } else {
            return response()->json('Something went wrong on the server.',$response->getStatusCode());
        }
    }
    
}
