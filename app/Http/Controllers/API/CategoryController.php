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
        $categories = CategoryResource::collection(Category::get());
        // return (new CategoryResource($categories))->response()->json();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(CategoryRequest $request)
    {

        $validated = $request->validated();
        $category = Category::create($request->all());
        return response()->json(new CategoryResource($user), 201);
    }


    public function show($id)
    {
        // $category = new CategoryResource(Category::find($id));
        // return response($category);

        $category = Category::find($id);
        if ($category) {
            return response(new CategoryResource($category));
        }
        return response('Category Not Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }
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
