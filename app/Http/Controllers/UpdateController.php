<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostReply;
use Illuminate\Http\Request;

use App\Http\Requests;

class UpdateController extends Controller
{
    public function index(Request $request)
    {
        $html = '';
        try {
            $post         = new Post();
            $post->status = $request->status;
            $post->user_id = \Auth::user()->id;
            $post->save();

            $posts = Post::where('id', $post->id)->with('replies')->first();
            $view = view('hrms.updates.status', ['post' => $posts]);
            $html = $view->render();


        }
        catch(\Exception $e)
        {
            \Log::info($e->getMessage());
            return json_encode(['status' => false]);
        }

        return json_encode(['status' => true, 'html' => $html]);
    }

    public function reply(Request $request)
    {
        $html = '';
        try {
            $reply = new PostReply();
            $reply->message = $request->reply;
            $reply->user_id = \Auth::user()->id;
            $reply->post_id = $request->post_id;
            $reply->save();

            $view = view('hrms.updates.reply', ['reply' => $reply]);
            $html = $view->render();
        }
        catch(\Exception $e)
        {
            \Log::info($e->getMessage());
            return json_encode(['status' => false]);
        }

        return json_encode(['status' => true, 'html' => $html, 'reply' => $reply]);
    }

    public function post($postId)
    {
        $post = Post::where('id', $postId)->with('replies')->first();
        return view('hrms.updates.post', compact('post'));
    }
}
