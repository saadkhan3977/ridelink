<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Google_Client;

class GoogleController extends Controller
{
    public function login(Request $request)
    {
        \Log::info($request->all());
        $validated = $request->validate([
            'data.idToken' => 'required|string',
        ]);

        $idToken = $validated['data']['idToken'];

        $client = new \Google\Client(['client_id' => env('GOOGLE_CLIENT_ID')]); // Google Client ID
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
