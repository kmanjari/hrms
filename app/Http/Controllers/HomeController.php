<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('replies')->where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('home', compact('posts'));
    }
}
