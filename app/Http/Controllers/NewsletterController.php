<?php

namespace App\Http\Controllers;

use App\User;
use Debugbar;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{

    public function subscribe(Request $request)
    {   
        $email = new \SendGrid\Mail\Mail(); 
        /*if (!Newsletter::isSubscribed($request->email)) {
            // We are gonna look if the email is an already register user to see if we can retrieve some information
            $user = User::where('email', '=', $request->email)->first();
            if ($user) {
                Newsletter::subscribeOrUpdate($request->email, ['firstName' => $user->firstname, 'lastName' => $user->lastname]);
            } else {
                Newsletter::subscribeOrUpdate($request->email);
            }
            if (Newsletter::lastActionSucceeded()) {
                return response()->json(['message' => 'You are well suscribed for the newsletter.'], $this->successStatus);    
            } else {
                return response()->json(['message' => Newsletter::getLastError()], $this->errorStatus); 
            }
            
        }
        return response()->json(['message' => 'You are already register on the newsletter, we already love you.'], $this->conflictStatus);
        */
    }

    public function unsubscribe(Request $request)
    {
       /* Newsletter::unsubscribe($request->email);

        // TODO : Here we should store the reason the user unsuscribe

        return response()->json(['message' => 'The user has been removed from the newxsletter list'], $this->successStatus);
        */
    }

}
