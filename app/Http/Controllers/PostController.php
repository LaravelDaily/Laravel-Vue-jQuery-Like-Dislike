<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function jquery()
    {
        $posts = Post::withCount('likes', 'dislikes')
            ->when(auth()->check(), function ($query) {
                $query->with(['ratings' => function ($query) {
                    $query->where('id', auth()->id());
                }]);
            })
            ->get();

        return view('posts.jquery', compact('posts'));
    }

    public function vue()
    {
        $posts = Post::withCount('likes', 'dislikes')
            ->when(auth()->check(), function ($query) {
                $query->with(['ratings' => function ($query) {
                    $query->where('id', auth()->id());
                }]);
            })
            ->get();

        return view('posts.vue', compact('posts'));
    }

    public function ratePost(Request $request)
    {
        if (auth()->guest()) {
            return response(['message' => 'You are not logged in. Please log in to rate post'], 401);
        }

        $request->validate([
            'type'    => 'required|in:like,dislike',
            'post_id' => 'required|exists:posts,id'
        ]);

        $user = auth()->id();
        $post = Post::find($request->input('post_id'));

        $unrated  = (boolean) $post->ratings()->where('user_id', $user)->where('type', $request->input('type'))->count();
        $detached = (boolean) $post->ratings()->detach($user);
        if (!$unrated) {
            $post->ratings()->attach($user, [
                'type' => $request->input('type')
            ]);
        }

        $post->loadCount('likes', 'dislikes');
        $likes    = $post->likes_count;
        $dislikes = $post->dislikes_count;

        return response(compact('detached', 'unrated', 'likes', 'dislikes'));
    }
}
