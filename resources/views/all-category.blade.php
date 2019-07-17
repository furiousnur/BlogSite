@extends('layouts.frontend.app')
@section('title', 'Category-Posts')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/category/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/category/responsive.css')}}">
@endpush
@section('content')
    <section class="blog-area section">
        <div class="container">
            <h3 class="title" style="text-align: center;"> All Category</h3>
            <hr>
            <div class="row">
                @if($categories->count()>0)
                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-3">
                            <div class="title">
                                <a href="{{route('category.posts', $category->slug)}}">
                                    <img style="height: 150px;"
                                        src="{{asset('storage/category/'.$category->image)}}"
                                        alt="{{$category->name}}">
                                </a>
                            </div>
                            <div class="blog-info">
                                <h4 class="title">
                                    <a href="{{route('category.posts', $category->slug)}}"><b>
                                            {{$category->name}}</b>
                                    </a>
                                </h4>
                            </div><!-- blog-info -->
                        </div><!-- col-lg-4 col-md-6 -->
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-info">
                                    <h4 class="title">
                                        Sorry!! No Post Found.
                                    </h4>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endif
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->
@endsection
@push('js')
@endpush
