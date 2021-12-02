<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Logo;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyController extends Controller
{
    public function companyInfo(Request $request){
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $companyInfo = Company::where('user_id', '=', $user_id)->first();
        $logoInfo = Logo::where('user_id', '=', $user_id)->first();

        if($request->file('logo')){
            $image = $request->file('logo');
            $existLogo = Logo::where('user_id', '=', $user_id)->first();
            $logoName = $image->getClientOriginalName();
            $logoData = $image->move(public_path('images/' . $user_id), $logoName);
            $type = $logoData->guessExtension();
            $path = $logoData->getPath();
            if(!$existLogo){
                $logo = new Logo;
                $logo->name = $logoName;
                $logo->path = $path;
                $logo->type = $type;
                $logo->user_id = $user_id;
                $logo->save();
                return back();
            } else {
                $existLogo->name = $logoName;
                $existLogo->path = $path;
                $existLogo->type = $type;
                $existLogo->user_id = $user_id;
                $existLogo->save();
                return back();
            }
        }

        if($logoInfo != null){
            $logoName = $logoInfo->name;
        } else {
            $logoName = 'camera.svg';
        }
        
        if($companyInfo == null){
            if(!$request->has('submit')){
                return view('companyInfo.set');
            } else {
                $company = new Company;
                $company->name = $request->companyName;
                $company->country = $request->companyCountry;
                $company->user_id = $user_id;
                $company->save();
                return back();
            }
        }

        $productOne = Product::where('user_id', $user_id)->first();
        if ($productOne == null){
            $product = "Нет товаров";
        } else {
            $productAll = Product::where('user_id', $user_id)->get();
            $product = $productAll;
        }
        
        return view('companyInfo.get', ['companyInfo' => $companyInfo, 'logoName' => $logoName, 'user_id' => $user_id, 'product' => $product]);
    }

    public function infoEdit(Request $request){
        $user_id = Auth::user()->id;
        $company = Company::where('user_id', '=', $user_id)->first();
        if($request->method() == 'POST'){
            $company->name = $request->companyName;
            $company->country = $request->companyCountry;
            $company->save();
            return redirect('/main');
        } else {
            return redirect('/main');
        }
    }

}
