<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $data = Banner::all();
        return $this->sendResponse($data,'all banner');
    }

    public function store(Request $request)
    {
        try {


            $validateUser = Validator::make($request->all(),
            [
                'image' => 'required|mimes:jpg,png,jpeg'
            ]);



            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            $banner = new Banner();
            $banner->link = $request->link;
            $banner->image = $this->saveImage('banner',$request->image);
            $banner->save();

            return $this->sendResponse($banner,'Banner created successfull');

        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function view($id)
    {

        try {

            $banner = Banner::findOrFail($id);
            return $this->sendResponse($banner,'Success');
        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function update(Request $request,$id)
    {
        try {

            $validateUser = Validator::make($request->all(),
            [
                'link' => 'required',
                'image' => 'sometimes|mimes:jpg,png,jpeg'
            ]);


            $banner = Banner::findOrFail($id);


            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            $banner->link = $request->link;
            if($request->image){
                $banner->image = $this->saveImage('banner',$request->image);
            }
            $banner->save();

            return $this->sendResponse($banner,'Banner updated successfull');

        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->delete();
            return $this->sendResponse(null,'banner delete successfull');
        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }
}
