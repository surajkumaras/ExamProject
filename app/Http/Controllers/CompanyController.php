<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    public function settingDashboard()
    {
        $data = Company::first();
        // return $data;
        return view('admin.setting', compact('data'));
    }

    //========== Save Setting ==============//
    public function updateSetting(Request $request)
    {
    //    return $request->all();

       try
       {
           $company = Company::first();
           $company->name = $request->cname;


           if($request->hasFile('logo'))
           {
                $logoPath = 'uploads/logos/';
                $oldLogo = $company->logo;
                if ($oldLogo && File::exists(public_path($logoPath . $oldLogo))) 
                {
                    File::delete(public_path($logoPath . $oldLogo));
                }

               $file = $request->file('logo');
               $filename = time() . '.' . $file->getClientOriginalExtension();
               $file->move(public_path('uploads/logo'), $filename);
               $company->logo = $filename;
           }
           
           $company->email = $request->email;
           $company->phone = $request->phone_number['full'];
           $company->address = $request->caddress;
           $company->country = $request->country;
           $company->state = $request->state;
           $company->city = $request->city;
           $company->zip = $request->pin;
           $company->save();

           return redirect()->back()->with('success', 'Company Information Updated Successfully');
       }
       catch(\Exception $e)
       {
           return $e->getMessage();
       }
    }
}
