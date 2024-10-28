<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $attendees = Attendee::with('event')->get();
        return view('attendee', compact('events', 'attendees'));
        //
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

        try {
            $validateddate = $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|string|email|unique:attendees,email',
                'event_id' => 'required|string|exists:events,id'
            ]);
            Attendee::create([
                'name' => $validateddate['name'],
                'email' => $validateddate['email'],
                'event_id' => $validateddate['event_id'],
            ]);
            $response = Attendee::with('event')->get();
            return response()->json(['data' => $response, 'message' => 'Attendee stored Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
        try {
            $response = Attendee::where('id', $id)->with('event')->get();
            return response()->json(['data' => $response], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validateddate = $request->validate([
                'update_email' => ['required', 'string', 'email', Rule::unique('attendees', 'email')->ignore($id),],
                'update_name' => 'required|string|min:3',
                'updateevent_id' => 'required|string|exists:events,id'
            ]);


            $attendee = Attendee::findOrFail($id);
            $attendee->update([
                'name' => $validateddate['update_name'],
                'email' => $validateddate['update_email'],
                'event_id' => $validateddate['updateevent_id'],
            ]);
            $response = Attendee::with('event')->get();
            return response()->json(['data' => $response, 'message' => "Attendee Updated Successfully"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $attendeedetail = Attendee::findOrFail($id);
            $attendeedetail->delete();
            $response = Attendee::with('event')->get();
            return response()->json(['data' => $response, 'message' => "Event Deleted Successfully"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function search(Request $request)
    {
        try {
            $search=$request->search;
            $query=Attendee::query();
            $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->orWhereHas('event',function($q) use ($search){
                $q->where('title','LIKE',"%$search%");
            });
            $response=$query->with('event')->get();
            return response()->json(['data' => $response], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
