<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Google_Client;
use App\Models\Wallet;

class GoogleController extends Controller
{
    public function login(Request $request)
    {

        \Log::info($request->all());

        $idToken = $request->data['idToken'];;

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

            Wallet::updateOrCreate([
                'user_id' => $user->id,
            ]);

            // Generate token
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['success'=>true,'message'=>'User register successfully','token' => $token,'user_info'=>$user], 200);
        } else {
            return response()->json(['error' => 'Invalid Google token'], 401);
        }
    }

}
