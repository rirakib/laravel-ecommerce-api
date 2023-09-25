<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseController as Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::all();
        return $this->sendResponse($data,'all categories');
    }

    public function store(Request $request)
    {
        try {


            $validateUser = Validator::make($request->all(),
            [
                'title' => 'required',
                'image' => 'required|mimes:jpg,png,jpeg'
            ]);



            if($validateUser->fails()){
                return $this->sendError('validation error',$validateUser->errors(),401);
            }

            $category = new Category();
            $category->title = $request->title;
            $category->slug = Str::slug($request->title);
            $category->image = $this->saveImage('category',$request->image);
            $category->save();

            return $this->sendResponse($category,'Category created successfull');



            // $category->image =
        } catch (\Throwable $th) {
            return $this->sendError('failed',$th->getMessage(),500);
        }
    }
}
