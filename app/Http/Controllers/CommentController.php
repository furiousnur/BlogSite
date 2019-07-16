<?php

namespace App\Http\Controllers;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request,$post){
        $validate = $request->validate([
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post;
        $comment->comment = $request->comment;
        $comment->save();

        Toastr::success('Your comment successfully published.', 'success');
        return redirect()->back();
    }
}
