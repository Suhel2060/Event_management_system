<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AllEventDetailController extends Controller
{
    public function index(){
        $datas = Attendee::with(['event.category'])->get();


        return view('alleventdetail',compact('datas'));
    }
    public function search(Request $request){

        try {
            $search=$request->search;
            $query=Attendee::query();
            $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->orWhereHas('event',function($q) use ($search){
                $q->where('title','LIKE',"%$search%")
            ->orwhere('location','LIKE',"%$search%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                });
            });
            $response=$query->with('event.category')->get();
            return response()->json(['data' => $response], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
}
