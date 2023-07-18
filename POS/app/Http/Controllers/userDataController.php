<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userDataController extends Controller
{
     function userPage(Request $req){
        return view('admin.user');
    }

    function userRequest(Request $req){
       return User::get();

    }
}
