<?php

namespace App\Http\Controllers\Api;

use auth;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        'post' =>$post,
    ]);

    }

    // UPDATE 

    
}
