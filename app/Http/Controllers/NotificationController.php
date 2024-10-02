<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;
use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        return view('notification');
    }

    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token =  $request->token;
        $user = Auth::user()->save();
        \Log::info("User device token updated: " . $request->token);
        return response()->json(['Token successfully stored.']);
    }

    public function sendFcmNotification(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string',
        //     'body' => 'required|string',
        // ]);

        // $token = auth()->user()->device_token;
        // $title = $request->title;
        // $body = $request->body;
        // $data = $request->input('data',[]);

        // $response = $this->firebaseService->sendNotification($token, $title, $body, $data);
        // dd($response);
        // return response()->json(['Notification sent successfully.']);

        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $fcm = auth()->user()->device_token;

        if (!$fcm) {
            return response()->json(['message' => 'User does not have a device token'], 400);
        }

        $title = $request->title;
        $description = $request->body;
        $projectId = config('fir-push-64503'); # INSERT COPIED PROJECT ID

        $credentialsFilePath = storage_path('app/firebase_creds.json');
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        \Log::info(["Firebase access token: " => json_encode($token)]);
        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => "hello",
                    "body" => "Suraj Kumar",
                    // "content_available" => true,
                    // "priority" => "high",
                ],
            ]
        ];
        $payload = json_encode($data);

        // $payload = [
        //     "message" => [
        //         "token" => $fcm,  // Replace with the actual FCM token
        //         "notification" => [
        //             "title" => $title,  // Replace with your dynamic title
        //             "body" => $description,    // Replace with your dynamic body
        //         ],
        //         "webpush" => [
        //             "fcm_options" => [
        //                 "link" => "https://yourwebsite.com"  // Replace with your actual website link
        //             ]
        //         ]
        //     ]
        // ];
        // $payload = json_encode($payload);
        


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/fir-crud-e30d0/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return response()->json([
                'message' => 'Curl Error: ' . $err
            ], 500);
        } else {
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    

    }
}
