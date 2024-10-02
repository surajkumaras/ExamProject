<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;

class ConfigurationController extends Controller
{
    public function index()
    {
        $config = Config::first();
        // return $config;
        return view('admin.config')->with('config', $config);
    }

    public function setMail(Request $request)
    {
        // return $request->all();

        $config = Config::first();
        if($config)
        {
            $config->mail_host = $request->mail_host;
            $config->mail_port = $request->mail_port;
            $config->mail_enctryption = $request->mail_encryption;
            $config->mail_mailer = $request->mail_mailer;
            $config->mail_username = $request->mail_username;
            $config->mail_password = $request->mail_password;
            $config->mail_mailfrom = $request->mail_mailfrom;
            
        }
        else
        {
            $config = new Config();
            $config->mail_host = $request->mail_host;
            $config->mail_port = $request->mail_port;
            $config->mail_enctryption = $request->mail_encryption;
            $config->mail_mailer = $request->mail_mailer;
            $config->mail_username = $request->mail_username;
            $config->mail_password = $request->mail_password;
            $config->mail_mailfrom = $request->mail_mailfrom;
            
        }
        $config->save();
        return response()->json(['status'=>true,'msg'=>'Mail configuration updated successfully']);
    }

    public function setGoogleAuth(Request $request)
    {
        // return $request->all();

        $config = Config::first();
        if($config)
        {
            $config->google_client_id = $request->google_client_id;
            $config->google_client_secret = $request->google_client_secret;
            $config->google_redirect_uri = $request->google_redirect_uri;
        }
        else 
        {
            $config = new Config();
            $config->google_client_id = $request->google_client_id;
            $config->google_client_secret = $request->google_client_secret;
            $config->google_redirect_uri = $request->google_redirect_uri;
        }
        $config->save();
        return response()->json(['status'=>true,'msg'=>'Google Auth Setup configuration updated successfully']);
    }

    public function setFacebookAuth(Request $request)
    {
        // return $request->all();

        $config = Config::first();
        if($config)
        {
            $config->facebook_client_id = $request->facebook_client_id;
            $config->facebook_client_secret = $request->facebook_client_secret;
            $config->facebook_redirect_uri = $request->facebook_redirect_uri;
        }
        else 
        {
            $config = new Config();
            $config->facebook_client_id = $request->facebook_client_id;
            $config->facebook_client_secret = $request->facebook_client_secret;
            $config->facebook_redirect_uri = $request->facebook_redirect_uri;
        }
        $config->save();
        return response()->json(['status'=>true,'msg'=>'Facebook Auth Setup configuration updated successfully']);
    }
}
