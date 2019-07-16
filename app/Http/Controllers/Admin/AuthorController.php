<?php

namespace App\Http\Controllers\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthorController extends Controller
{
    public function index(){
        $authors = User::authors()
                ->withCount('posts')
                ->withCount('comments')
                ->withCount('favorite_posts')
                ->get();
        return view('admin.author', compact('authors'));
    }

    public function destroy($id){
        $author = User::findOrFail($id)->delete();
        Toastr::success('Delete has been successfully.','success');
        return redirect()->back();
    }
}
