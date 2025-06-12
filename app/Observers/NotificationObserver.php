<?php

namespace App\Observers;

use App\Models\Notification;
use App\Models\User;

class NotificationObserver
{
    /**
     * Handle the Notification "created" event.
     */
    public function created(Notification $notification): void
    {
        $users = explode(',', $notification->users);

        $api_key =$this->getAccessToken();
        foreach ($users as $user_id) {
            $user = User::where('fcm_token','!=',null)->whereId($user_id)->first();
            if ($user) {
//                dd($user->fcm_token, $notification->title, $notification->description, $notification->target_type, $notification->target_id, $user->platform,$api_key);
                sendNotification($user->fcm_token, $notification->title, $notification->description, $notification->target_type, $notification->target_id, $user->platform,$api_key);
            }
        }
    }

    public function getAccessToken()
    {
        $projectId = 'low-calories-e6f96'; // Replace with your Firebase project ID

        $firebaseScope = 'https://www.googleapis.com/auth/firebase.messaging';
        try {
            // JSON key string for Google service account (from Firebase)
            $jsonKeyString = '{
  "type": "service_account",
  "project_id": "low-calories-e6f96",
  "private_key_id": "fc78f010cb3e8e73414da1b2094992f8f966f760",
  "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDdJSrSgAdS4N3U\nl8wWHKfJ0Uz+nCudpcRw525NSGU6jHoo4M1G1Aywq0uFgx0m/zlx+4Sbl5J6u1k4\nDSsixuuMrzs/lmNQ95eGOx66+xf+cQOcs+Wq486RbvMVax2qQ+8a2D39+dEWD0Q2\nJIuNlh84tIfREbLq9T1tScL8Zy9XTss48f6K7Lp7ZzJJnDB9DpnhSgTDADQXZI7X\nEHDFDBZbmqYeQoCisZk3oHSoe9J/SRXzSkkF1loK4GG2X6BwhhIbFgcJke7wkpYt\nOc6993cy6dcBK9tO1xw35fhbRUipcLNVS0puXcSKWFnEW37hP/LLc7WR2CHUOOu1\n5iYhJN9bAgMBAAECggEAX7y7cS3j/clDv8mHnPsC2Kg3wPIzH6ioBojqg6KX0GUI\nbbIErGkYpVNC+qXsdPmBEQtmOUXBMEjzMwTga8naJ6mk6L5eeKr3ejEV+LTDim+6\ntJhdEUJWJzf1HIym5xNJ7EE5dT41emtZiGcB02XuVkoxkh0ra/SHh0yrkUHKiOzR\nohB5f4vbCDPTBYI2qrbppcN4aAzHFTbAW/F0HZZ+rhRBC+APl/0wIHaLPBxOvtXW\nai5MKdyXgAJP88awvDyOThCaoHnhp74i5m6BAizAJpzAMQqgZbJwQPsGKswvnFdt\n9FYgJSEuUs1F52Z4r5Um/8z5z7CHDe2QwIxCmodKwQKBgQDuRFb58XCQ1cKnhDXr\nr6cE1M4zMxvlZtTfXm3X9D16yhDEFDuAllRnimeXZxsyRwNEM2K7s4OPoOiK4H/w\ni8WcelvCPjas6zm7gksSoWQW8zqa6VGlycJAPTwoho6o+ADXuVyFqe9nI7fJxHIB\np1AVf7Qta1FIWlyDAEo7UkqnuQKBgQDtmpv/E8nPKgCMIWw463R2ubb9YcqwoAz7\nfhrRj5C+ZFxzfQrUqlTR1nN69AAgWpdEfFWAwpk61bjlLmInnsIGS/Ug34b7aRIp\njzzFRdlWVEjsyHX4BCvwxfnDXN3xOFI0pmYMTudi0JjCoWuHD5Wlveg6nnmmtWg0\ndx/y+cjhswKBgCrzetJXqbkSL6LO/IFeCreePQWRwweZf+o8NYTmbGbEIj2WgBtv\n/gskMgRi+84WawpSUQwREjhEA2d1jNqp95d7nyrm2ChXxvJ8TFgxa7+PXRMr2CIQ\nusmlwEB18SWYf15j9b/KoHNxRuJCXWLa7F7TxIEjhWWLlH2xAbCr5vVRAoGAZ7Bp\nE0/XagiyZHTRfaWDFazGJp1ejuXJxJarrXgxemTh06Rl7ZjHmyszCh0hUP03tjNs\nPNyvcfWC0sEDJLcrhQPw3X+usFiSDIDtzElHJ11w1aRFlw56/n/nF1KXqIUjmsZj\nEkv8viq5/3XiLvamH8ZYafxuqknQR9UUpDxNZfECgYEAwocDsqsH4ozVrXm2UsCP\ntgOw4xxKvOcM8j0mOF2zdwGlL+uKti4f9D/hO88e+cGRYnMK/pSx2c3SZuorwkF6\noXn0UaOmHhoX+lkfok1J3ETLl0ndJVfbDZPnwMStzh9OqI1v1ern6CNi10yM+FMH\njwggPywMsBuR2xskAwh9xak=\n-----END PRIVATE KEY-----\n",
  "client_email": "firebase-adminsdk-fhevv@low-calories-e6f96.iam.gserviceaccount.com",
  "client_id": "114800103208985871628",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fhevv%40low-calories-e6f96.iam.gserviceaccount.com",
  "universe_domain": "googleapis.com"
}';        // Decode JSON and get credentials
            $credentials = json_decode($jsonKeyString, true);
////        // Create a scoped client for Firebase messaging
//            $client = new Client();
//            $client->setAuthConfig($credentials);
//            $client->addScope($firebaseScope);
//            // Get the access token
//
//            $client->fetchAccessTokenWithAssertion();
//            return $client->getAccessToken()['access_token'];

            $client = new \Google_Client();
            $client->setAuthConfig($credentials);
            $client->addScope($firebaseScope);
            $client->fetchAccessTokenWithAssertion();
            return $client->getAccessToken()['access_token'];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Handle the Notification "updated" event.
     */
    public function updated(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     */
    public function deleted(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     */
    public function restored(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     */
    public function forceDeleted(Notification $notification): void
    {
        //
    }
}
