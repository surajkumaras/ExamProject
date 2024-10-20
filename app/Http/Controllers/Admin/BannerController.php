<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banner');
    }

    public function store(Request $request)
    { //return $request->all();
        try{
            $data = new Banner();
            $data->title = $request->title;
            $data->subtitle = $request->desc;
            if($request->hasFile('bannerImage'))
            {
                    // $logoPath = 'uploads/banner/';
                    // $oldLogo = $company->logo;
                    // if ($oldLogo && File::exists(public_path($logoPath . $oldLogo))) 
                    // {
                    //     File::delete(public_path($logoPath . $oldLogo));
                    // }

                $file = $request->file('bannerImage');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banner/'), $filename);
                // $company->logo = $filename;
                $data->image = $filename;
            }
            $data->link = $request->urllink;
            $data->save();

            return redirect()->back()->with('success', 'Banner Added Successfully');
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
