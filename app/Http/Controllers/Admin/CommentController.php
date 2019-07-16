<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(){
        $comments = Comment::latest()->get();
        return view('admin.comment', compact('comments'));
    }

    public function destroy($id){
        Comment::findOrFail($id)->delete();
        Toastr::success('Comments successfully deleted.', 'success');
        return redirect()->back();
    }
}
