<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;

class GoogleController extends Controller
{
    public function login(Request $request)
    {
        $idToken = $request->data['idToken'];

        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]); // Client ID from Google Console
        $payload = $client->verifyIdToken($idToken);

        if ($payload) {
            // Extract user details
            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];

            // Find or create user
            $user = User::updateOrCreate(
                ['google_id' => $googleId],
                ['email' => $email, 'name' => $name]
            );

            // Generate token
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Invalid Google token'], 401);
        }
    }
}
