<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Mail;

class AuthController extends Controller
{
    public function loadRegister()
    {
        if(Auth::user() && Auth::user()->is_admin ==1)
        {
            return redirect('admin/dashboard');
        }
        else if(Auth::user() && Auth::user()->is_admin == 0)
        {
            return redirect('/dashboard');
        }

        return view('register');
    }

    public function studentRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'You have successfully registered! Please login.');
    }

    public function loadLogin()
    {
        if(Auth::user() && Auth::user()->is_admin ==1)
        {
            return redirect('admin/dashboard');
        }
        else if(Auth::user() && Auth::user()->is_admin == 0)
        {
            return redirect('/dashboard');
        }

        return view('login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) 
        {
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.dashboard');
            }
            else 
            {
                return redirect()->route('student.dashboard');
            }
        }
        else 
        {
            return back()->with('error', 'Invalid login details');
        }
    }

    public function loadDashboard()
    {
        return view('student.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function forgetPasswordLoad()
    {
        return view('forget-password');
    }

    public function forgetPassword(Request $request)
    {
        try{
           $user = User::where('email', $request->email)->get();

            if(count($user) > 0)
            {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'reset-password/'.$token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Click the link below to reset your password';

                Mail::send('forgetPasswordMail',['data'=>$data],function($message) use($data){
                   $message->to($data['email'])->subject($data['title']);
                });

               $dateTime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email'=>$request->email],
                    []
                );
            }
            else
            {

            }
        }catch(\Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }
}
