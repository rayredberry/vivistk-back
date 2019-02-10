<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    /**
     * Table Name.
     */
    protected $table = 'user_verifications';

    /**
     * Fillable Fields.
     */
    protected $fillable = [
        'email',
        'code',
        'attempts'
    ];

    /**
     * Send Verification Code to User.
     */
    public function sendEmail()
    {
        $timeout = 5;
        $status  = true;
        $content = 'SMS CODE: ' . $this -> code;
        $content = str_replace(' ', '%20', $content);

        if(env('APP_ENV') == 'local')
        {
            return true;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://81.95.160.47:80/mt/sendsms?username=santa&password=S69&client_id=689&service_id=1&to=' .  '995' . $this -> phone . '&text=' . $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($ch);

        if (curl_errno($ch))
        {
            $status = false;
        }

        curl_close($ch);

        return $status;
    }
}
