<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
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
       $exams =  Exam::with('subjects')->orderBy('date')->get();
        return view('student.dashboard',['exams'=>$exams]);
    }

    public function adminDashboard()
    {
        $subjects = Subject::all();
        return view('admin.dashboard',compact('subjects'));
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
                $url = $domain.'/reset-password?token='.$token;

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
                    [
                        'email'=>$request->email,
                        'token'=>$token,
                        'created_at'=>$dateTime
                    ]
                );

                return back()->with('success','Please check your mail to reset your password');
            }
            else
            {
                return back()->with('error', 'Email not exists!');
            }
        }catch(\Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }


    public function resetPasswordLoad(Request $request)
    {
       $resetData = PasswordReset::where('token', $request->token)->get();

       if(isset($request->token) && count($resetData) >0)
       {
            $user = User::where('email', $resetData[0]['email'])->get();
            return view('resetPassword',compact('user'));
       }
       else 
       {
           return view('404');
       }

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        try
        {
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email', $request->email)->delete();
            return "<h2>Password reset successfully!</h2>";
        }catch(\Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }
}
