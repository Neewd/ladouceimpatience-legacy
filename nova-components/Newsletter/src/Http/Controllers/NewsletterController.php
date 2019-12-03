<?php

namespace Neewd\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Debugbar;
use Vansteen\Sendinblue\Facades\Sendinblue;

class NewsletterController extends Controller
{

    public function indexCampaigns(Request $request)
    {
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\EmailCampaignsApi(
            new \GuzzleHttp\Client(),
            $config
        );

        try {
            $result = $apiInstance->getEmailCampaigns();
            $encoded = json_encode($result['campaigns'], true);
            return $encoded;
        } catch (Exception $e) {
            Debugbar::error('Exception when calling EmailCampaignsApi->getEmailCampaigns: ', $e->getMessage(), PHP_EOL);
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function createCampaign(Request $request)
    {
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\EmailCampaignsApi(
            new \GuzzleHttp\Client(),
            $config
        );

        $emailCampaigns = new \SendinBlue\Client\Model\CreateEmailCampaign();
        $sender = new \SendinBlue\Client\Model\CreateEmailCampaignSender();
        $sender['email'] = $request->sender;
        $emailCampaigns['name'] = $request->name;
        $emailCampaigns['sender'] = $sender;
        $emailCampaigns['htmlContent'] = $request->template;
        $emailCampaigns['inlineImageActivation'] = false;
        $emailCampaigns['subject'] = $request->subject;

        try {
            $result = $apiInstance->createEmailCampaign($emailCampaigns);
            print_r($result);
            $encoded = json_encode($result['campaigns'], true);
            return $encoded;
        } catch (Exception $e) {
            echo 'Exception when calling EmailCampaignsApi->createEmailCampaign: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function getContactFromList(Request $request)
    {
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\ContactsApi(
            new \GuzzleHttp\Client(),
            $config
        );

        try {
            $result = $apiInstance->getContactsFromList($request->listId);
            return json_encode($result['contacts'], true);
        } catch (Exception $e) {
            Debugbar::error('Exception when calling EmailCampaignsApi->getEmailCampaigns: ', $e->getMessage(), PHP_EOL);
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function sendCampaignNow(Request $request)
    {
        $config = Sendinblue::getConfiguration();
        $apiInstance = new \SendinBlue\Client\Api\EmailCampaignsApi(
            new \GuzzleHttp\Client(),
            $config
        );
        $campaignId = $request->campaignId;

        print_r($request->all());

        try {
            $result = $apiInstance->sendEmailCampaignNow($campaignId);
            print_r($result);
            return json_encode($result['contacts'], true);;
        } catch (Exception $e) {
            Debugbar::error('Exception when calling EmailCampaignsApi->getEmailCampaigns: ', $e->getMessage(), PHP_EOL);
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
