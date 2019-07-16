<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request){
        $validate = $request->validate([
           'email' => 'required|email|unique:subscribers'
        ]);

        $email = new Subscriber();
        $email->email = $request->email;
        $email->save();

        Toastr::success('You successfully added in our subscriber list.', 'success');
        return redirect()->back();
    }
}
