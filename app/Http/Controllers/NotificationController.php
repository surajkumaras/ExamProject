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
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $token = auth()->user()->device_token;
        $title = $request->title;
        $body = $request->body;
        $data = $request->input('data',[]);

        $response = $this->firebaseService->sendNotification($token, $title, $body, $data);
        dd($response);
        return response()->json(['Notification sent successfully.']);

    }
}
