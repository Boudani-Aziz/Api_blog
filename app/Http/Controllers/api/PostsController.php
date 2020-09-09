<?php

namespace App\Http\Controllers\Api;


use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct(){

        return $this->middleware('jwtAuth');
    }

    public function create(Request $request){
    $post = new Post;
    $post->user_id =Auth::user()->id;
    $post->desc = $request->desc;

    // Verifion si la photo existe 
    if($request->photo != ''){

        $photo = time().'jpg';
        file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
        $post->photo = $photo;
    }

    $post->save();
    $post->user;

    return response()->json([
        'success' =>true,
        'message' =>'posted',
        'post' =>$post
    ]);

    }

    // UPDATE 

    public function update(Post $post ,Request $request){

        //$post = Post::find($request->id);
            // check if user is editing his own post 
            if(Auth::user()->id != $request->id){
                return response()->json([
                    'success'=>false,
                    'message' =>'unauthorized access'
                ]);

            }
                $post->desc = request('desc');
                $post->update();

                return response()->json([
                    'success'=> true,
                    'message'=> 'post edited'
                ]);
            
        }

// DELETE 

        public function delete(Post $post,Request $request){

            //$post = Post::find($request->id);
                // check if user is editing his own post 
                if(Auth::user()->id != $request->id){
                    return response()->json([
                        'success'=>false,
                        'message' =>'unauthorized access'
                    ]);
                }

            //check if post has photo to delete 

            if($post->photo != ''){
                Storage::delete('public/posts/'.$post->photo);
            }
            $post->delete();

            return response()->json([
                'success'=> true,
                'message'=> 'post deleted'
            ]);


            }

// POST 

        public function posts(){

            $posts = Post::orderBy('id','Desc')->get();

            foreach($posts as $post){
                //GET USER OF POST 
            $post->user;
                
               //COMMENT COUNT
            $post['CommentCount'] = count($post->comments);

                //LIKES COUNT
            $post['LikesCount'] = count($post->Likes);

                //CHECK IF USER LIKED HIS OWN POST
            
            $post['selflike'] = false;

            foreach($post->Likes as $like){

                if($like->user_id == Auth::user()->id){
                    $post['selflike'] = true;
                }
            }

            return response()->json([
                'success' =>true,
                'posts' =>$posts
            ]);

            }
            

        }
}
