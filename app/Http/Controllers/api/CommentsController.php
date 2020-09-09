<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    // CREATE COMMENT

    public function create(Request $request){

        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment= $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' =>'comment added'

        ]);
    }
    
    //UPDATE COMMENT
    public function update(Comment $comment,Request $request){

        //$post = Post::find($request->id);
            // check if user is editing his own post 
            if(Auth::user()->id != $request->id){
                return response()->json([
                    'success'=>false,
                    'message' =>'unauthorized access'
                ]);

            }
                $comment->comment = request('comment');
                $comment->update();

                return response()->json([
                    'success'=> true,
                    'message'=> 'comment edited'
                ]);
            

    }

    //DELETE COMMENT

    public function delete(Comment $comment,Request $request){

        //$post = Post::find($request->id);
            // check if user is editing his own post 
            if(Auth::user()->id != $request->id){
                return response()->json([
                    'success'=>false,
                    'message' =>'unauthorized access'
                ]);

            }
               
                $comment->update();

                return response()->json([
                    'success'=> true,
                    'message'=> 'comment delete'
                ]);
            

    }

    //COMMENTS 

    public function comments(Request $request){

        $comments = Comment::where('post_id',$request->id);
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
