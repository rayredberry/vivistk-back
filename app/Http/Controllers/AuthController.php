<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;

use JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'hardcore', 'register']]);
    }


    /**
     * Register a user, then login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
        ]);



        $user = User::create(['name' => request('name'), 'email' => request('email'), 'password' => bcrypt(request('password'))]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'ელ.ფოსტა ან პაროლი არასწორია']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'კიდევ სცადეთ'], 500);
        }

        //DB::disconnect();

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via User model.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hardcore(User $user)
    {
        try {
            // attempt to login using the given user model
            if (! $token = auth('api')->fromUser($user)) {
                return response()->json(['success' => false, 'error' => 'ელ.ფოსტა ან პაროლი არასწორია']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'კიდევ სცადეთ'], 500);
        }

        //DB::disconnect();

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['id' => auth()->user()->id]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'user' => auth()->user()
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
