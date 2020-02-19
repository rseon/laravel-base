<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\PostRequest;
use App\Http\Resources\Manager\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $list = Post::latest();

            if(!$request->admin || !Auth::user()->can('viewAny', Post::class)) {
                $list->where('author_id', Auth::id());
            }

            return PostResource::collection($list->get());
        }
        return view('manager.post.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = true;
        $data['author_id'] = Auth::id();

        $post = Post::create($data);
        $post->categories()->sync($request->categories);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        if(!Auth::user()->can('update', $post)) {
            return response(['error' => 'Unauthorized.'], 401);
        }

        $post->update($request->validated());

        $post->categories()->sync($request->categories);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(!Auth::user()->can('delete', $post)) {
            return response(['error' => 'Unauthorized.'], 401);
        }

        $post->delete();

        return response(null, 204);
    }
}
