<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::all();
        $events=Event::all();
        return view('event',compact('categories','events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validateddate=$request->validate([
                'title'=>'required|string|min:3|unique:events,title',
                'description'=>'required|string|min:8',
                'date'=>'required|date',
                'location'=>'nullable|string',
                'category_id'=>'nullable|string|exists:categories,id'
            ]);
            Event::create([
                'title'=>$validateddate['title'],
                'description'=>$validateddate['description'],
                'date'=>$validateddate['date'],
                'location'=>$validateddate['location'],
                'category_id'=>$validateddate['category_id'],
            ]);
            $response=Event::with('category')->get( );
            return response()->json(['data'=>$response,'message'=>'Event stored Successfully'],200);
        }catch(Exception $e){
            return response()->json(['message'=>$e->getMessage()],500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $response=Event::where('id',$id)->with('category')->get();
            return response()->json(['data'=>$response],200);
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

            $validateddate=$request->validate([
                'update_title'=>['required','string','min:3', Rule::unique('events', 'title')->ignore($id),],
                'update_description'=>'required|string|min:8',
                'update_date'=>'required|date',
                'update_location'=>'nullable|string',
                'updatecategory_id'=>'nullable|string|exists:categories,id'
            ]);

            $event=Event::findOrFail($id);
            $event->update([
                'title'=>$validateddate['update_title'],
                'description'=>$validateddate['update_description'],
                'date'=>$validateddate['update_date'],
                'location'=>$validateddate['update_location'],
                'category_id'=>$validateddate['updatecategory_id'],
            ]);
            $response=Event::with('category')->get();
            return response()->json(['data'=>$response,'message'=>"Event Updated Successfully"],200);
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
$eventdetail=Event::findOrFail($id);
$eventdetail->delete();
$response=Event::with('category')->get();
return response()->json(['data'=>$response,'message'=>"Event Deleted Successfully"],200);

      }catch(Exception $e){
        return response()->json(['message'=>$e->getMessage()],500);
      }
    }
}
