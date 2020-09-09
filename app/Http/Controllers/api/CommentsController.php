<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{

    public function __construct(){

        return $this->middleware('jwtAuth');
    }
    
    // CREATE COMMENT

    public function create(Request $request){

        $comment = new Comment;

        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' =>'comment added'

        ]);
    }
    
    //UPDATE COMMENT
    public function update(Request $request){

           $comment = Comment::find($request->id);
            // check if user is editing his own post 
            if(Auth::user()->id != $comment->id){
                return response()->json([
                    'success'=>false,
                    'message' =>'unauthorized access'
                ]);

            }else{
                $comment->comment = request('comment');
                $comment->update();

                return response()->json([
                    'success'=> true,
                    'message'=> 'comment edited'
                ]);
            }
                
            

    }

    //DELETE COMMENT

    public function delete(Request $request){

           $comment = Comment::find($request->id);
            // check if user is editing his own post 
            if(Auth::user()->id != $comment->id){
                return response()->json([
                    'success'=>false,
                    'message' =>'unauthorized access'
                ]);

            }
               
                $comment->delete();

                return response()->json([
                    'success'=> true,
                    'message'=> 'comment delete'
                ]);
            

    }

    //COMMENTS 

    public function comments(Request $request){

        $comments = Comment::where('post_id',$request->id)->get();
            //SHOW USER EACH COMMENT

        foreach($comments as $comment){

            $comment->user;
        }
        return response()->json([
            'success' =>true,
            'comments' =>$comments
        ]);
        
    }
}
