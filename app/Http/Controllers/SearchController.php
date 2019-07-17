<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $query  = $request->input('query');
        $posts = Post::where('title', 'LIKE', "%$query%")
                        ->orWhereHas('tags', function($q) use ($query) {
                            return $q->where('name', 'LIKE', '%' . $query . '%');
        })->approved()->status()->get();
//        dd($posts);
        return view('search', compact('posts', 'query'));
    }
}
