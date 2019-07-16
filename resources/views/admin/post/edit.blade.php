@extends('layouts.backend.app')
@section('title', 'Post')
@push('css')
    <!-- Custom Css -->
    <link href="{{asset('assets/backend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush
@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <form method="post" action="{{route('admin.post.update', $post->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Post
                            </h2>
                        </div>
                        <div class="body">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="title" class="form-control" name="title" value="{{$post->title}}">
                                    <label class="form-label">Post Title</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Featured Image</label>
                                <input type="file" name="image">
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="publish" name="status" class="filled-in" value="1"
                                {{$post->status == true ? 'checked' : ''}}>
                                <label for="publish">Publish</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Categories And Tags
                            </h2>
                        </div>
                        <div class="body">
                            {{--category form group--}}
                            <div class="form-group form-float">
                                <div class="form-line {{$errors->has('tags') ? 'focused error' : ''}}">
                                    <label for="tag">Select Categories</label>
                                    <select name="categories[]" id="category" class="form-control show-tick"
                                            data-live-search="true" multiple>
                                        @foreach($categories as $category)
                                            <option
                                                @foreach($post->categories as $postCategory)
                                                {{$postCategory->id == $category->id ? 'selected' : ''}}
                                                @endforeach
                                                value="{{$category->id}}">{{$category->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{--tag form group--}}
                            <div class="form-group form-float">
                                <div class="form-line {{$errors->has('tags') ? 'focused error' : ''}}">
                                    <label for="tag">Select Tags</label>
                                    <select name="tags[]" id="tag" class="form-control show-tick"
                                            data-live-search="true" multiple>
                                        @foreach($tags as $tag)
                                            <option
                                                @foreach($post->tags as $postTag)
                                                {{$postTag->id == $tag->id ? 'selected' : ''}}
                                                @endforeach
                                                value="{{$tag->id}}">{{$tag->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <a class="btn btn-danger m-t-15 waves-effect" href="{{route('admin.post.index')}}">BACK</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Body
                            </h2>
                        </div>
                        <div class="body">
                            <textarea name="body" id="tinymce">{{$post->body}}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Vertical Layout | With Floating Label -->
    </div>
@endsection
@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    {{--    <!-- Multi Select Plugin Js -->--}}
    <script src="{{asset('assets/backend/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
    <!-- TinyMCE -->
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <!-- Custom Js -->
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
        });
    </script>
@endpush
