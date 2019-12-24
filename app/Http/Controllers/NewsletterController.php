<?php

namespace App\Http\Controllers;

use App\Participant;
use App\User;
use Debugbar;
use Illuminate\Http\Request;
use Vansteen\Sendinblue\Facades\Sendinblue;
use Str;

class NewsletterController extends Controller
{

    public function subscribe(Request $request)
    {
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $config
        );
        $listId = 2;

        // We are gonna look if the email is an already register user to see if we can retrieve some information
        $user = User::where('email', '=', $request->email)->first();

        // Check if the participant is not existing yet
        $participant = Participant::where('email', '=', $request->email)->first();
        if (!$participant) {
            // Create a participant 
            $participant = new Participant();
            $participant->email = $request->email;
            if ($user) {
                $participant->firstname = $user->firstname;
                $participant->lastname = $user->lastname;
                $participant->birth_date = $user->birth_date;
                $participant->list_id = $listId;
            }
            $participant->unsubscribe_token = Str::random(80);
            $participant->save();

            $createContact = new \SendinBlue\Client\Model\CreateContact();
            $createContact['email'] = $request->email;

            if ($user) {
                $createContact['attributes'] = array(
                    'FIRSTNAME' => $user->firstname,
                    'LASTNAME' => $user->lastname,
                    'UNSUBSCRIBE_TOKEN' => $participant->unsubscribe_token
                );
            } else {
                $createContact['attributes'] = array(
                    'UNSUBSCRIBE_TOKEN' => $participant->unsubscribe_token
                );
            }
            $createContact['listIds'] = [$listId];
            $createContact['updateEnabled'] = true;

            try {
                $result = $apiInstance->createContact($createContact);
                return response()->json(['message' => 'L\'email vient d\'être abonné.'], $this->successStatus);
            } catch (Exception $e) {
                echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
            }
        } else {
            if ($participant->unsubscribe_reason_id !== null) {
                $participant->unsubscribe_reason_id = null;
                $participant->save();

                $email = $participant->email;
                $updateContact = new \SendinBlue\Client\Model\UpdateContact();
                $updateContact['listIds'] = [$listId];
                try {
                    $apiInstance->updateContact($email, $updateContact);
                    return response()->json(['message' => 'L\'email vient d\'être réabonné.'], $this->successStatus);
                } catch (Exception $e) {
                    echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
                }
            } else {
                return response()->json(['message' => 'L\'email est déjà abonné.'], $this->conflictStatus);
            }
        }
    }

    public function unsubscribe(Request $request)
    {   
        // Check if the participant is not existing yet
        $participant = Participant::where('email', '=', $request->email)->first();
        if (!$participant) {

        } else {
           // TODO : On va chercher la raison de l'unsubscribe et on met à jour le participant, et on vérifie qu'on a bien un participant qui à un token quand même
        } 
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $config
        );
        $listId = 2;
        $contactEmails = new \SendinBlue\Client\Model\RemoveContactFromList();
        $contactEmails['emails'] = [$request->email];

        try {
            $result = $apiInstance->removeContactFromList($listId, $contactEmails);
            return response()->json(['message' => 'Vous êtes bien désabonné, vous n\'entendrez plus parler de nous.'], $this->conflictStatus);
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->removeContactFromList: ', $e->getMessage(), PHP_EOL;
        }
    }
}
