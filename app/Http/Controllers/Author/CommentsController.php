<?php

namespace App\Http\Controllers\Author;

use App\User;
use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(){
        $posts = Auth::user()->posts;
        return view('author.comment', compact('posts'));
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id() ){
            $comment->delete();
            Toastr::success('Comments successfully deleted.', 'success');
        }else{
            Toastr::error('You are not authorized to delete this post', 'error');
        }
        return redirect()->back();
    }
}
