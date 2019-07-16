@extends('layouts.frontend.app')
@section('title')
    {{$author->name}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/category/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/category/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/profile/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/profile/responsive.css')}}">
    <style>
        .favorite-posts {
            color: deeppink;
        }
    </style>
@endpush
@section('content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{$author->name}}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        @if($posts->count()>0)
                            @foreach($posts as $post)
                                <div class="col-md-6 col-sm-12">
                                    <div class="card h-100">
                                        <div class="single-post post-style-1">
                                            <div class="blog-image"><img src="{{asset('storage/post/'.$post->image)}}"
                                                                         alt="{{$post->title}}"></div>
                                            <a class="avatar" href="{{route('author.profile', $post->user->username)}}">
                                                <img src="{{asset('storage/profile/'.$post->user->image)}}" alt="{{$post->title}}">
                                            </a>
                                            <div class="blog-info">
                                                <h4 class="title"><a
                                                        href="{{route('details.post', $post->slug)}}"><b>
                                                            {{str_limit($post->title, '30')}}</b></a></h4>
                                                <ul class="post-footer">
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
                                                    <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a>
                                                    </li>
                                                    <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                                                </ul>
                                            </div><!-- blog-info -->
                                        </div><!-- single-post -->
                                    </div><!-- card -->
                                </div><!-- col-lg-4 col-md-6 -->
                            @endforeach
                        @else
                                <div class="col-lg-8 col-sm-12">
                                <div class="card h-100">
                                    <div class="single-post post-style-1">
                                        <div class="blog-info">
                                            <h4 class="title">
                                                <h2>Sorry!! No post Fount</h2>
                                            </h4>
                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->
                        @endif
                            {{$posts->links()}}
                    </div><!-- row -->
                </div><!-- col-lg-8 col-md-12 -->
                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p>{{$author->name}}</p><br>
                            <p>{{$author->about}}</p><br>
                            <strong>Author Since: {{$author->created_at}}</strong><br>
                            <strong>Total Posts: {{$author->posts->count()}}</strong>
                        </div>

                        <div class="subscribe-area">

                            <h4 class="title"><b>SUBSCRIBE</b></h4>
                            <div class="input-area">
                                <form>
                                    <input class="email-input" type="text" placeholder="Enter your email">
                                    <button class="submit-btn" type="submit"><i class="ion-ios-email-outline"></i>
                                    </button>
                                </form>
                            </div>

                        </div><!-- subscribe-area -->

                        <div class="tag-area">

                            <h4 class="title"><b>TAG CLOUD</b></h4>
                            <ul>
                                <li><a href="#">Manual</a></li>
                                <li><a href="#">Liberty</a></li>
                                <li><a href="#">Recomendation</a></li>
                                <li><a href="#">Interpritation</a></li>
                                <li><a href="#">Manual</a></li>
                                <li><a href="#">Liberty</a></li>
                                <li><a href="#">Recomendation</a></li>
                                <li><a href="#">Interpritation</a></li>
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section -->
@endsection
@push('js')
@endpush
