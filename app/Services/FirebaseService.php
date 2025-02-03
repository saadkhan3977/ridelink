<?php
// app/Services/FirebaseService.php

namespace App\Services;

use Google\Client as GoogleClient;
use GuzzleHttp\Client as GuzzleClient;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseService
{
    private $guzzleClient;
    private $serviceAccountPath;

    public function __construct()
    {
        $this->serviceAccountPath = storage_path('app/google-services.json');
        $this->guzzleClient = new GuzzleClient(); // Initialize Guzzle HTTP Client
    }

    public function sendNotification($fcmToken, $title, $body)
    {
        // Get the OAuth 2.0 token
        $url = 'https://fcm.googleapis.com/v1/projects/ridelink-be22c/messages:send'; // Replace with your project ID
        $accessToken = $this->getAccessToken();

        // Sending the request with the Guzzle HTTP Client
        $response = $this->guzzleClient->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => $fcmToken, // Make sure to use $fcmToken instead of $token
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getAccessToken()
    {
        $client = new GoogleClient(); // Use the Google Client for OAuth 2.0
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }
	
	public function setData($path, $data)
    {
		$database = Firebase::database();
        $database->getReference($path)->set($data);
    }

    public function updateData($path, $data)
    {
		$database = Firebase::database();
        $database->getReference($path)->update($data);
    }
}
