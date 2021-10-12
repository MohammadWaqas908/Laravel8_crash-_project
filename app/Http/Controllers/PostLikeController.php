<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Mail\Postliked;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function store(Post $post, Request $request)
    {
        // dd($post->likes()->withTrashed()->get());

        if($post->likedBy($request->user())){
            return response(null, 409); //409 is an error page not working
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        if (!$post->likes()->onlyTrashed()->where('user_id',$request->user()->id)->count()) {
            Mail::to($post->user)->send(new Postliked(auth()->user(), $post));
        }

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
