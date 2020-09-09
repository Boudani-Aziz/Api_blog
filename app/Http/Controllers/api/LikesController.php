<?php

namespace App\Http\Controllers\Api;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{

    public function __construct(){

        return $this->middleware('jwtAuth');
    }

    public function like(Request $request){

        $like = Like::where('post_id',$request->id)->where('user_id',Auth::user()->id)->get();
        //CHECK IF IT RETURN 0 THEN THIS POST IS LIKED AND SHOULD BE LIKED ELSE UNLIKED

        if(count($like) > 0){

            $like[0]->delete();

            return response()->json([
                'success' =>true,
                'message' =>'unliked',
            ]);
        }

        $like = new Like;
        $like->user_id = Auth::user()->id;
        $like->post_id = $request->id;
        $like->save();

        return response()->json([
            'success' =>true,
            'message' =>'liked',
        ]);
    }
}
