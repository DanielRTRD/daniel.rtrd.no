<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:posts.create|posts.update|posts.destroy'])->only(['index']);
        $this->middleware(['permission:posts.create'])->only(['create', 'store']);
        $this->middleware(['permission:posts.update'])->only(['update', 'edit']);
        $this->middleware(['permission:posts.destroy'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->paginate(10);

        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts,title'],
            'draft' => ['required', 'integer'],
            'published_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'body' => ['required', 'string', 'min:25'],
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->draft = $request->draft;
        $post->published_at = $request->published_at;
        $post->slug = Str::of($post->title)->slug('-');
        $post->user_id = auth()->user()->id;
        $post->save();
        $post->attachTags($request->tags);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'draft' => ['required', 'integer'],
            'published_at' => ['required', 'date_format:Y-m-d H:i:s'],
            'body' => ['required', 'string', 'min:25'],
        ]);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->draft = $request->draft;
        $post->published_at = $request->published_at;
        $post->slug = Str::of($post->title)->slug('-');
        $post->user_id = auth()->user()->id;
        $post->save();
        $post->syncTags($request->tags);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
