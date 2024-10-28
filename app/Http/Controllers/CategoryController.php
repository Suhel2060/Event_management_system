<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::all();
        return view('category',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validateddata=$request->validate([
                'category'=>'required|string|unique:categories,name|min:3'
            ]);
            Category::create(['name'=>$validateddata['category']]);
            $responsedata=Category::all();
            return response()->json(["status"=>true,'message'=>'category stores successfully','data'=>$responsedata],200);
        }
        catch(ValidationException $e){
            return response()->json(["status" => false, 'message' => $e->errors()], 422);

        }
        catch(Exception $e){
            return response()->json(["status" => false, 'message' => 'An error occurred. Please try again.'], 500);        }
      

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $responsedata=Category::where('id',$id)->first();
            return response()->json(['data'=>$responsedata],200);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    try{
        $validateddata=$request->validate(['categoryname'=>'required|string|unique:categories,name|min:3']);
        $category = Category::findOrFail($id);
        $category->update(['name'=>$validateddata['categoryname']]);
        $responsedata=Category::all();
        return response()->json(['status'=>true,'data'=>$responsedata,'message'=>'Category Updated Successfuly'],200);
    }catch(Exception $e){
        return response()->json(['message'=>$e->getMessage()],500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);
            if(!$category->canDelete()){
                throw new Exception("The Event created through this category should be deleted first",500);
            }
            $category->delete();
            $responsedata=Category::all();
            return response()->json(['status'=>true,'data'=>$responsedata,'message'=>'Category Deleted Successfully'],200);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }
    }
}
