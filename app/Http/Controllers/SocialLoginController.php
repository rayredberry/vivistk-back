<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;

class SocialLoginController extends Controller
{
    public function fbLogin()
    {
        $token = Input::get('token');

        $fb = new \Facebook\Facebook([
            'app_id' => env('FB_ID'),
            'app_secret' => env('FB_SECRET'),
            'default_graph_version' => 'v2.12',
        ]);
        try {
            $fbresponse = $fb->get('/me?fields=id,name,email', $token);

            $me = $fbresponse->getGraphUser();
            $userId = $me->getId();
            $email = $me->getEmail();
            $name = $me->getName();

            $user = User::whereEmail($email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'name' => $name,
                    'password' => md5(rand(1,10000)),
                ]);
            }

            $token = auth('api')->fromUser($user);
            return response()->json([
    			'success' => true,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL(),
                'user' => auth()->user()
    		]);
        }
        catch (\Facebook\Exceptions\FacebookResponseException $e) {
            dd($e);
            //Handle this error, return a failed request to the app with either 401 or 500
        }
        catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e);
            //Handle this error, return a 500 error – something is wrong with your code
        }
    }

    public function googleLogin()
    {
        $token = Input::get('token');

        $client_id = env('GOOGLE_CLIENT_ID');

        $client = new \Google_Client([
           'client_id' => $client_id
        ]);

        $payload = $client->verifyIdToken($token);

        if($payload['aud'] == $client_id) {
            $name = $payload['name'];
            $email = $payload['email'];

            $user = User::whereEmail($email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'name' => $name,
                    'password' => md5(rand(1,10000)),
                ]);
            }

            $token = auth('api')->fromUser($user);
            return response()->json([
    			'success' => true,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL(),
                'user' => auth()->user()
    		]);
        }

        return response()->json([
            'error' => 'incorrect client id'
        ]);
    }
}
