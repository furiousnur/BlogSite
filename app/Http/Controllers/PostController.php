<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function details($slug){
        $post = Post::where('slug',$slug)->first();

        $blogkey = 'blog_'.$post->id;
        if (!Session::has($blogkey)){
            $post->increment('view_count');//view_count is the column name of post table.
            Session::put($blogkey,1);
        }

        $randomposts = Post::approved()->status()->take(3)->inRandomOrder()->get();
        return view('single-post', compact('post', 'randomposts'));
    }

    public function index(){
        $posts = Post::latest()->approved()->status()->paginate(9);
        return view('posts',compact('posts'));
    }


    public function category($slug){
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->status()->get();
        return view('category-posts', compact('category', 'posts'));
    }

    public function tag($slug){
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts()->approved()->status()->get();
        return view('tag-posts', compact('tag', 'posts'));
    }
}
