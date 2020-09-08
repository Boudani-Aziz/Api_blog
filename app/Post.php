<?php

namespace App;

use App\Like;
use App\User;
use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){

        return $this->belongsTo(User::class);
    }

    public function comment(){

        return $this->belongsTo(Comment::class);
    }

    public function like(){

        return $this->belongsTo(Like::class);
    }

}
