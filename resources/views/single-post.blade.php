@extends('layouts.frontend.app')
@section('title')
    {{$post->title}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/frontend/single-post/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/single-post/responsive.css')}}">
    <style>
        {{--.header-bg{--}}
        {{--    height: 500px;--}}
        {{--    width: 100%;--}}
        {{--    background-image: url({{asset('storage/post/'.$post->image)}});--}}
        {{--    background-size: cover;--}}
        {{--}--}}
        {{--.favorite-posts{--}}
        {{--    color:deeppink;--}}
        {{--}--}}
    </style>
@endpush
@section('content')
    <div class="header-bg">
    </div><!-- slider -->
    <section class="post-area section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 no-right-padding">
                    <div class="main-post">
                        <div class="blog-post-inner">
                            <div class="post-info">
                                <div class="left-area">
                                    <a class="avatar" href="{{route('author.profile', $post->user->username)}}"><img
                                            src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image">
                                    </a>
                                </div>
                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{$post->user->name}}</b></a>
                                    <h6 class="date">{{$post->created_at->diffForhumans()}}</h6>
                                </div>
                            </div><!-- post-info -->
                            <h3 class="title"><span><b>{{$post->title}}</b></span></h3>
                            <div class="para">
                                <img src="{{asset('storage/post/'.$post->image)}}" alt="">
                                <hr>
                                {!! html_entity_decode($post->body) !!}
                            </div>
                            <ul class="tags">
                                @foreach($post->tags as $tag)
                                    <li>
                                        <a style="background-color: #2fb7aa; color: #fff !important;"
                                           href="{{route('tag.posts', $tag->slug)}}">{{$tag->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest
                                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list ' +
                                                 'you need to login first', 'info',{
                                                    closeButton:true,
                                                    progressBar:true,
                                                 })">
                                            <i class="ion-heart"></i>{{$post->favorite_to_users->count()}}
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" onclick="document.getElementById
                                            ('favorite-form-{{$post->id}}').submit();"
                                           class="{{!Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count()
                                                == 0 ? 'favorite-posts' : ''}}">
                                            <i class="ion-heart"></i>{{$post->favorite_to_users->count()}}
                                        </a>
                                        <form id="favorite-form-{{$post->id}}" style="display: none;"
                                              action="{{route('post.favorite', $post->id)}}" method="POST">
                                            @csrf
                                        </form>
                                    @endguest
                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                            </ul>
                            <ul class="icons">
                                <li>SHARE :</li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->
                <div class="col-lg-4 col-md-12 no-left-padding">
                    <div class="single-post info-area">
                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>About Author</b></h4>
                            <p>{{$post->user->about}}</p>
                        </div>
                        <div class="sidebar-area subscribe-area">
                            <h4 class="title"><b>SUBSCRIBE</b></h4>
                            <div class="input-area">
                                <form method="POST" action="{{route('subscriber.store')}}">
                                    @csrf
                                    <input class="email-input" type="email" name="email" placeholder="Enter your email">
                                    <button class="submit-btn" type="submit">
                                        <i class="icon ion-ios-email-outline"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- tag-area -->
                        <hr>
                        <div class="tag-area">
                            <h4 class="title"><b>TAG CLOUD</b></h4>
                            <ul>
                                @foreach($post->tags as $tag)
                                    <li>
                                        <a style="background-color: #2fb7aa; color: #fff !important;"
                                           href="{{route('tag.posts', $tag->slug)}}">{{$tag->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- tag-area -->
                        <hr>
                        <!-- category-area -->
                        <div class="tag-area">
                            <h4 class="title"><b>CATEGORY CLOUD</b></h4>
                            <ul>
                                @foreach($post->categories as $category)
                                    <li>
                                        <a style="background-color: #2fb7aa; color: #fff !important;"
                                           href="{{route('category.posts', $category->slug)}}">{{$category->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div><!-- category-area -->
                        <hr>
                    </div><!-- info-area -->
                </div><!-- col-lg-4 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- post-area -->
    <section class="comment-section">
        <div class="container"><br>
            <h4><b>POST COMMENT</b></h4>
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                            <h4>For the new comment you have to login first.
                                <a style="color: blue;" href="{{route('login')}}"><b>Login</b></a>
                            </h4>
                        @else
                            <form method="post" action="{{route('comment.store', $post->id)}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true"
                                              aria-invalid="false">
                                    </textarea>
                                    </div><!-- col-sm-12 -->
                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit">
                                            <b>POST COMMENT</b>
                                        </button>
                                    </div><!-- col-sm-12 -->
                                </div><!-- row -->
                            </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{$post->comments()->count()}})</b></h4>
                    @if($post->comments()->count() > 0)
                        <hr>
                        @foreach($post->comments as $comment)
                            <div class="commnets-area ">
                                <div class="comment">
                                    <div class="post-info">
                                        <div class="left-area">
                                            <a class="avatar" href="#"><img
                                                    src="{{asset('storage/profile/'.$comment->user->image)}}"
                                                    alt="Profile Image"></a>
                                        </div>
                                        <div class="middle-area">
                                            <a class="name" href="#"><b>{{$comment->user->name}}</b></a>
                                            <h6 class="date">{{$comment->created_at->diffForhumans()}}</h6>
                                        </div>
                                    </div><!-- post-info -->
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div><!-- commnets-area -->
                        @endforeach
                        <hr>
                    @else
                        <hr>
                        <div class="commnets-area ">
                            <div class="comment">
                                <h4>No Comments Yet.</h4>
                            </div>
                        </div>
                        <hr>
                    @endif
                </div><!-- col-lg-8 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
    <section class="recomended-area section">
        <div class="container">
            <div class="row">
                @foreach($randomposts as $randompost)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-image"><img src="{{asset('storage/post/'.$randompost->image)}}"
                                                             alt="{{$randompost->title}}"></div>
                                <a class="avatar" href="{{route('author.profile', $post->user->username)}}">
                                    <img src="{{asset('storage/profile/'.$randompost->user->image)}}"
                                         alt="{{$randompost->title}}"></a>
                                <div class="blog-info">
                                    <h4 class="title"><a href="{{route('details.post', $randompost->slug)}}"><b>
                                                {{$randompost->title}}</b></a></h4>
                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('To add favorite list you ' +
                                                 'need to login first', 'info',{
                                                    closeButton:true,
                                                    progressBar:true,
                                                 })"><i class="ion-heart"></i>{{$randompost->favorite_to_users->count()}}
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById
                                                    ('favorite-form-{{$randompost->id}}').submit();"
                                                   class="{{!Auth::user()->favorite_posts->where('pivot.post_id', $randompost->id)->count()
                                                == 0 ? 'favorite-posts' : ''}}">
                                                    <i class="ion-heart"></i>{{$randompost->favorite_to_users->count()}}
                                                </a>
                                                <form id="favorite-form-{{$randompost->id}}" style="display: none;"
                                                      action="{{route('post.favorite', $randompost->id)}}"
                                                      method="POST">
                                                    @csrf
                                                </form>
                                            @endguest
                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a>
                                        </li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$randompost->view_count}}</a></li>
                                    </ul>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            </div><!-- row -->
        </div><!-- container -->
    </section>

@endsection()
@push('js')
@endpush
