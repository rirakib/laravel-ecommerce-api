<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::all();
        return $this->sendResponse($data,'all brand');
    }

    public function store(Request $request)
    {
        try {


            $validateUser = Validator::make($request->all(),
            [
                'title' => 'required|unique:brands',
                'image' => 'required|mimes:jpg,png,jpeg'
            ]);



            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            $brand = new Brand();
            $brand->title = $request->title;
            $brand->slug = Str::slug($request->title);
            $brand->image = $this->saveImage('brand',$request->image);
            $brand->save();

            return $this->sendResponse($brand,'Brand created successfull');

        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function view($slug)
    {

        try {

            $brand = Brand::whereSlug($slug)->firstOrFail();
            return $this->sendResponse($brand,'Success');
        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function update(Request $request,$slug)
    {
        try {

            $validateUser = Validator::make($request->all(),
            [
                'title' => 'required | unique:brands,slug,'.$slug,
                'image' => 'sometimes|mimes:jpg,png,jpeg'
            ]);


            $brand = Brand::whereSlug($slug)->firstOrFail();


            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            $brand->title = $request->title;
            $brand->slug = Str::slug($request->title);
            if($request->image){
                $brand->image = $this->saveImage('brand',$request->image);
            }
            $brand->save();

            return $this->sendResponse($brand,'Brand updated successfull');

        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }

    public function destroy($slug)
    {
        try {
            $brand = Brand::whereSlug($slug)->firstOrFail();
            $brand->delete();
            return $this->sendResponse(null,'brand delete successfull');
        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }
}
