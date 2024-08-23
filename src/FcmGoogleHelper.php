<?php

namespace gitspark\FcmHttpV1;

use Google\Client as GClient;
use Google\Service\FirebaseCloudMessaging;
use Google_Exception;

class FcmGoogleHelper
{
    public static function configureClient()
    {
        $path = base_path() . '/' . env('FCM_JSON');

        $client = new GClient();
        try {
            $client->setAuthConfig($path);
            $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);

            $accessToken = FcmGoogleHelper::generateToken($client);

            $client->setAccessToken($accessToken);

            $oauthToken = $accessToken["access_token"];

            return $oauthToken;
        } catch (Google_Exception $e) {
            return $e;
        }
    }

    private static function generateToken($client)
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        return $accessToken;
    } 
}
