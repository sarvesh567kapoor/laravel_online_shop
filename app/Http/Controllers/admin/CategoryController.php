<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::latest();

        if(!empty($request->get('keyword')))
        {
            $category = $category->where('name','like','%'.$request->get('keyword').'%');

        }
        $category = $category->paginate(10);
        $data['categories'] = $category;
        return view('admin.category.list',$data);

    }

    public function create() {
        
        return view('admin.category.create');
        
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if($validator->passes())
        {

            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            session()->flash('success','Category added successfully');

            return response()->json([
                'status' => true,
                'message' =>"Category added successfully"
            ]);

        }
        else {
            return response()->json([
                'status' => false,
                'errors' =>$validator->errors()
            ]);
        }

    }

    public function update() {

    }

    public function destroy() {
        
    }

}
