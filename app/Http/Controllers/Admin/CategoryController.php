<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg',
            'f_image' => 'required|mimes:jpeg,bmp,png,jpg'
        ]);
        // get form logo image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
//          make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//
            // check category slider dir is exists
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
            //            resize image for category slider and upload
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/'.$imagename,$slider);
        } else {
            $imagename = "default.png";
        }

        //featured image
        $fimage = $request->file('f_image');
        $slug = str_slug($request->name);
        if (isset($fimage))
        {
//          make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $fimagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$fimage->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('category/featured'))
            {
                Storage::disk('public')->makeDirectory('category/featured');
            }
//            resize image for category and upload
            $category = Image::make($fimage)->resize(1600,479)->stream();
            Storage::disk('public')->put('category/featured/'.$fimagename,$category);
        } else {
            $fimagename = "default.png";
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->fimage = $fimagename;
        $category->save();
        Toastr::success('Category Successfully Saved :)' ,'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'mimes:jpeg,bmp,png,jpg'
        ]);
        // get form image
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $category = Category::find($id);

        if (isset($image))
        {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }
//            delete old image
            if (Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }

//            resize image for category and upload
            $categoryimage = Image::make($image)->resize(1600,479)->stream();
            Storage::disk('public')->put('category/'.$imagename,$categoryimage);
            //            check category slider dir is exists
            if (!Storage::disk('public')->exists('category/slider'))
            {
                Storage::disk('public')->makeDirectory('category/slider');
            }
//            delete old slider image
            if (Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
            //            resize image for category slider and upload
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);
        } else {
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category Successfully Updete :)' ,'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        if (Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Category delete has been success!!', 'success');
        return redirect()->back();
    }
}
