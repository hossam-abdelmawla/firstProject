<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryResource::collection(Category::get())->additional([
            "message"=>'wqeqweqwe'
                ]);
        return $categories;
    }

    public function store(CategoryRequest $request)
    {


        $category = Category::create($request->all());

        return new CategoryResource($category);
        // return CategoryResource::make($category);
    }


    public function show($id)
    {
        // $category = new CategoryResource(Category::find($id));
        // return response($category);

        $category = Category::find($id);
        if ($category) {
            return new CategoryResource($category);
        }
        return response()->json([
            'message' => 'Category Not Found'
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {

        $category = Category::find($id);
        if (!$category) {
            return response('Category Not Found');
        }
        $category->update($request->all());
        $category->save();
        return response(new CategoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response('Category Not Found');
        }
        $category->delete();
        return response(new CategoryResource($category));
    }
}
