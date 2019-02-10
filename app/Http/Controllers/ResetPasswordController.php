<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\UserVerification;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /**
     * Reset User's Password.
     */
    public function resetPassword(Request $request)
    {
        // Inputed Phone Number
        $password = Input::get('password');
        $confirm  = Input::get('password_confirmation');

        if($password != $confirm) {
            return response()->json(['error' => "Passwords don't match"]);
        }

        /* Check User's Verification Code. */
        // Inputed Verification Code
        $code     = Input::get('code');
        // Inputed Phone Number
        $email    = Input::get('email');
        // Get User's Verification Code Record
        $verification = UserVerification::where('email', $email) -> orderBy('id', 'DESC') -> first();
        // Check if Verification Code exists and equals to Inputed Code
        if ( ! $verification || $verification -> code != $code) {
            /*$this -> validate($request, [
                'sms_code' => 'required'
            ], [
                'sms_code.required' => 'Incorrect SMS Code'
            ]);*/
            return response()->json(['error' => 'კოდი არასწორია']);
        } else {
            // Delete Record from user_verifications Table
            $verification -> delete();
        }
        // Update Password
        $user = User::where('email', $email) -> first();
        if ($user)
        {
            $user -> password = bcrypt($password);
            $user -> save();
            // Login User
        }
        else
        {
            /*$this -> validate($request, [
                'no_user' => 'required'
            ], [
                'no_user.required' => 'მობილურის ნომრით მომხმარებელი არ მოიძებნა'
            ]);*/
            return response()->json(['error' => 'ელ.ფოსტით მომხმარებელი არ მოიძებნა']);
        }
        return response()->json(['success' => 'Ok'], 200);
    }
}
